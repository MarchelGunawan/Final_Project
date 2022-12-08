import pymysql
import csv


#database connection
connection = pymysql.connect(host="localhost",user="root",passwd="",database="librarysystemdb" )
cursor = connection.cursor()
# some other statements  with the help of cursor
rows = []
with open('ratings.csv', encoding = 'cp850') as csv_file:
    csvreader = csv.reader(csv_file, delimiter=',')
    header = next(csvreader)
    for row in csvreader:
        rows.append(row)
for i in range(len(rows)):
    query = f"INSERT INTO review(user_id, book_id, rating) VALUES ('{rows[i][0]}','{rows[i][1]}', '{rows[i][2]}')"
    cursor.execute(query)
    connection.commit()
connection.close()