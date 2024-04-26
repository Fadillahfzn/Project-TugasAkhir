import mysql.connector
import re
import string
from cleantext import clean
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# Membuat koneksi ke database
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="taproject"
)

# Membuat cursor
mycursor = mydb.cursor()

# Mengambil semua data dari tabel data_raw
mycursor.execute("SELECT * FROM data_raw")
myresult = mycursor.fetchall()

# Mengambil data normalisasi kata
mycursor.execute("SELECT * FROM kata_normalisasi")
myresult1 = mycursor.fetchall()

# Membuat dictionary untuk normalisasi kata
normalization_dict = {norm[1]: norm[2] for norm in myresult1}

# Membuat objek stemmer dan stopword remover
stemmer = StemmerFactory().create_stemmer()
stopword_remover = StopWordRemoverFactory().create_stop_word_remover()

# Proses setiap baris data
for row in myresult:
    text = row[4]  # Misalkan kolom ke-5 adalah teks yang akan diproses
    
    # Pembersihan teks
    text = re.sub(r"@[A-Za-z0-9_]+", "", text)
    text = re.sub(r"#[A-Za-z0-9_]+", "", text)
    text = re.sub(r'http\S+', '', text)
    text = re.sub(r"RT\s+:", "", text)
    text = " ".join(text.split())
    text = clean(text, no_emoji=True)
    text = text.translate(str.maketrans('', '', string.punctuation))

    # Normalisasi kata
    words = text.split()
    normalized_words = [normalization_dict.get(word, word) for word in words]
    text = " ".join(normalized_words)

    # Stemming dan penghapusan stopword
    text = stemmer.stem(text)
    text = stopword_remover.remove(text)

    # Memasukkan data teks yang sudah dibersihkan ke tabel baru
    insert_query = "INSERT INTO data_clean (proses) VALUES (%s)"
    mycursor.execute(insert_query, (text,))

# Commit perubahan
mydb.commit()

# Menutup koneksi
mycursor.close()
mydb.close()
