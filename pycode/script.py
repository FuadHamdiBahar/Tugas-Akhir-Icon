import pandas as pd
import mysql.connector
import uuid

USER = 'root'
PASSWORD = 'root'

raw = pd.read_excel('POP.xlsx')[['pop_id', 'pop_name', 'pop_type', 'lat', 'lng', 'SBU_Name']]
raw.head()

db = mysql.connector.connect(
    host="localhost",
    user=USER,
    passwd=PASSWORD,
    database="myapp"
)

cursor = db.cursor()

for _, row in raw.iterrows():
    query = "insert into pops values ('{}', '{}', '{}', '{}', {}, {}, 'admin@admin.com', 'admin@admin.com', NOW(), NOW())".format(
        row.pop_id, row.pop_name, row.SBU_Name, row.pop_type, row.lat, row.lng
    )

    cursor.execute(query)

db.commit()

print("SELESAI POP")


raw = pd.read_csv('INNER_JOIN.csv')
raw.drop(columns='Unnamed: 0', inplace=True)

db = mysql.connector.connect(
    host="localhost",
    user=USER,
    passwd=PASSWORD,
    database="myapp"
)

cursor = db.cursor()

for _, row in raw.iterrows():
    UUID = uuid.uuid4()
    UUID = str(UUID)
    query = "insert into pssarpens values ('{}', '{}', '{}', {}, '{}', {}, 'admin@admin.com', 'admin@admin.com', NOW(), NOW())".format(
            UUID.upper(), row.pop_id, row.Perangkat, row.Tahun, row['Mitra Perlaksana'], row.Jumlah
    )
    
    cursor.execute(query)

db.commit()

print("SELESAI PSSARPEN I")

FILE_PATH = '2019.08.09_POP ICON+ All SBU IMPROVNET PS SARPEN rls_V4 - Copy.xlsx'
SHEET_NAMES = pd.ExcelFile(FILE_PATH).sheet_names

raw = pd.read_excel(FILE_PATH, sheet_name='Medan')
columns = raw.columns[7:22]

merged = []



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])

raw = pd.read_excel(FILE_PATH, sheet_name='Pekanbaru')
columns = raw.columns[6:17]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])

raw = pd.read_excel(FILE_PATH, sheet_name='Palembang')
columns = raw.columns[6:23]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])

raw = pd.read_excel(FILE_PATH, sheet_name='Jakarta')
columns = raw.columns[6:26]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])

raw = pd.read_excel(FILE_PATH, sheet_name='Bandung ')
columns = raw.columns[6:17]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
raw = pd.read_excel(FILE_PATH, sheet_name='Semarang')
columns = raw.columns[6:17]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
raw = pd.read_excel(FILE_PATH, sheet_name='Surabaya')
columns = raw.columns[6:18]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
raw = pd.read_excel(FILE_PATH, sheet_name='Denpasar')
columns = raw.columns[6:18]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            pass
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
            
raw = pd.read_excel(FILE_PATH, sheet_name='Makassar')
columns = raw.columns[6:17]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
raw = pd.read_excel(FILE_PATH, sheet_name='Balikpapan')
columns = raw.columns[6:21]



for _, row in raw.iterrows():
    for column in columns:
        if row[column] > 0:
            merged.append([row['POP ID'], column, 2024, None, row[column]])
            
            
import mysql.connector
import uuid

db = mysql.connector.connect(
    host="localhost",
    user=USER,
    passwd=PASSWORD,
    database="myapp"
)

cursor = db.cursor()

for row in merged:
    UUID = uuid.uuid4()
    UUID = str(UUID)
    query = "insert into pssarpens values ('{}', '{}', '{}', {}, '{}', {}, 'admin@admin.com', 'admin@admin.com', NOW(), NOW())".format(
            UUID.upper(), row[0], row[1], row[2], row[3], row[4]
    )
    
    cursor.execute(query)

db.commit()

print("SELESAI PSSARPEN II")