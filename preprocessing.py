import mysql.connector
import re
import string
from cleantext import clean
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# Menyambungkan ke basis data
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="taproject"
)
cursor = mydb.cursor()

# Mengambil semua data sekaligus
cursor.execute("SELECT DISTINCT * FROM data_raw")
raw_texts = cursor.fetchall()

cursor.execute("SELECT * FROM kamus")
kamus = {row[1]: row[2] for row in cursor.fetchall()}

# Mempersiapkan pola regex
user_pattern = re.compile("@[A-Za-z0-9_]+")
hashtag_pattern = re.compile("#[A-Za-z0-9_]+")
url_pattern = re.compile(r'http\S+')
rt_pattern = re.compile("RT : ")

# Menginisialisasi alat pemrosesan bahasa
stemmer = StemmerFactory().create_stemmer()
stopword = StopWordRemoverFactory().create_stop_word_remover()

seen_texts = set()
batch_data = []

# Memproses data
for record in raw_texts:
    username, original_text = record[15], record[4]
    # Hanya memproses data jika username tidak null dan teks belum diproses
    if username and original_text and original_text not in seen_texts:
        seen_texts.add(original_text)
        # Membersihkan teks
        text = user_pattern.sub('', original_text)
        text = hashtag_pattern.sub('', text)
        text = url_pattern.sub('', text)
        text = rt_pattern.sub('', text)
        text = " ".join(text.split())
        text = clean(text, no_emoji=True)
        text = text.translate(str.maketrans('', '', string.punctuation))

        # Mengganti kata-kata informal menjadi formal
        words = []
        for word in text.split():
            words.append(kamus.get(word, word))
        text = " ".join(words)

        # Mengaplikasikan stemming dan penghapusan stopword
        text = stemmer.stem(text)
        text = stopword.remove(text)

        # Menyiapkan data untuk dimasukkan secara batch
        batch_data.append((username, original_text, text))

# Memasukkan teks yang telah diproses ke basis data secara batch
insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
cursor.executemany(insert_query, batch_data)
mydb.commit()

# Menutup cursor dan koneksi
cursor.close()
mydb.close()
