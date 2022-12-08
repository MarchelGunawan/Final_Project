import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import os
import pymysql
import warnings

warnings.filterwarnings('ignore')

def data_preprocessing(books, ratings):
    columns = ['Book_id', 'isbn', 'Book_title', 'Book_author', 'original-publication_year', 'Book_qty', 'image', 'link_image', 'average_rating', 'ratings_count']
    new_books = books[columns]
    print(new_books.head())
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")
    print(new_books.info())
    new_books = new_books.fillna('NA')
    new_books.to_csv('books_cleaned.csv')
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")
    print(new_books.info())
    ratings.to_csv('ratings.csv')
    

if __name__ == "__main__":
    connection = pymysql.connect(host="localhost",user="root",passwd="",database="librarysystemdb" )
    cursor = connection.cursor()

    #take book data from database and convert it into data frame 
    query = "SELECT * FROM book" 
    cursor.execute(query)
    columns = [i[0] for i in cursor.description]
    books = pd.DataFrame(cursor.fetchall(), columns=columns)

    #take ratings data from database and convert it into data frame
    query = "SELECT * FROM review" 
    cursor.execute(query)
    columns2 = [i[0] for i in cursor.description]
    ratings = pd.DataFrame(cursor.fetchall(), columns=columns2)

    data_preprocessing(books, ratings)