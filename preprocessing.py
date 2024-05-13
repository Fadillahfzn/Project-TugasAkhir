import mysql.connector
import re
import string
from cleantext import clean
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="",
  database="taproject"
)

temp = []
mycursor = mydb.cursor()
mycursor.execute("SELECT DISTINCT * FROM data_raw")
myresult = mycursor.fetchall()

mycursor1 = mydb.cursor()
mycursor1.execute("SELECT * FROM kamus")
myresult1 = mycursor.fetchall()

factory = StemmerFactory()
stemmer = factory.create_stemmer()

stop_factory = StopWordRemoverFactory()
stopword = stop_factory.create_stop_word_remover()

seen_texts = set()
#Proses data
for x in myresult:
    if x[15] is not None and x[4] is not None:
        original_text = x[4]
        if original_text in seen_texts:
            continue  # Skip jika teks sudah diproses
        seen_texts.add(original_text)  # Tambahkan ke set
        #menghapus tag, hastag, link url, space, emoticon, dan tanda baca
        clean_text = re.sub("@[A-Za-z0-9_]+","", original_text)
        clean_text = re.sub("#[A-Za-z0-9_]+","", clean_text)
        clean_text = re.sub(r'http\S+', '', clean_text)
        clean_text = re.sub("RT : ", "", clean_text)
        clean_text = " ".join(clean_text.split())
        clean_text = clean(clean_text, no_emoji=True)
        clean_text = clean_text.translate(str.maketrans('', '', string.punctuation))

        #Mengubah kata informal menjadi formal
        s = ''
        clean_text = clean_text.split()
        
        for y in clean_text:
            for x1 in myresult1:
                if y == x1[1] :
                    y = x1[2]
            s = s + y + " "
            clean_text = s 

        #Stemming
        clean_text = stemmer.stem(str(clean_text))
        #Menghapus stopword
        clean_text = stopword.remove(clean_text)

        # Memasukkan data teks bersih ke tabel clean_text
        insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
        mycursor.execute(insert_query, (x[15], x[4], clean_text ))
    
    mydb.commit()

    # mycursor.execute("SELECT DISTINCT  FROM raw_data")