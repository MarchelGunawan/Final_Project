import pandas as pd
import numpy as np
import tensorflow as tf
import pymysql
import uvicorn
from sklearn.metrics.pairwise import cosine_similarity, linear_kernel
from sklearn.feature_extraction.text import TfidfVectorizer
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=[],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/items/{items_id}")
async def items(items_id:int):
    return {"items_id": items_id}

@app.get("/{user_id}")
async def get_recommendation(user_id: int):
    books = pd.read_csv('books_cleaned.csv')
    books = books.fillna("NA")
    ratings = pd.read_csv('ratings.csv')
    
    data_set = recommend(user_id, books, ratings, 5)
    print(data_set)
    return data_set

@app.get("/dashboard/{user_id}")
async def recommendation_today(user_id: int):
    books = pd.read_csv('books_cleaned.csv')
    books = books.fillna("NA")
    ratings = pd.read_csv('ratings.csv')
    
    data_set = recommend(user_id, books, ratings, 4)
    print(data_set)
    return data_set

#Defining a function that will recommend top 5 books
def recommend(user_id, books, ratings, qty):
    model = tf.keras.models.load_model('model.h5')
    books = books
    ratings = ratings

    book_id = list(ratings.book_id.unique()) #grabbing all the unique books

    book_arr = np.array(book_id) #geting all book IDs and storing them in the form of an array
    user_arr = np.array([user_id for i in range(len(book_id))])
    prediction = model.predict([book_arr, user_arr])

    prediction = prediction.reshape(-1) #reshape to single dimension
    prediction_ids = np.argsort(-prediction)[0:qty]

    recommended_books = pd.DataFrame(books.iloc[prediction_ids], columns = ['Book_id', 'isbn', 'Book_author', 'Book_title', 'image', 'link_image', 'average_rating'])
    print('Top 5 recommended books for you: \n')
    result = recommended_books.to_dict('index')
    return result

if __name__ == "__main__":
    uvicorn.run("api:app")
