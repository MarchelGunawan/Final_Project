import pandas as pd
import numpy as np
import tensorflow as tf
import warnings
from sklearn.model_selection import train_test_split
from tensorflow.keras.layers import Dense, Flatten, Input, Embedding, Concatenate, Dropout
from tensorflow.keras.callbacks import EarlyStopping
from tensorflow.keras.optimizers import Adam
warnings.filterwarnings('ignore')

if __name__ == "__main__":
    books = pd.read_csv('books_cleaned.csv')
    ratings = pd.read_csv('ratings.csv')

    #split the train data and test data 80% and 20%
    train, test = train_test_split(ratings, test_size=0.2, random_state=42)
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")
    print(f"Shape of train data: {train.shape}")
    print(f"Shape of test data: {test.shape}")
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")

    # take the total number of unique book id and user id
    book_id = ratings.book_id.nunique() 
    user_id = ratings.user_id.nunique()
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")
    print('Total books: ' + str(book_id))
    print('Total users: ' + str(user_id))
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")

    #Embedding layer for books
    books_input = Input(shape=[1])#1st Input Layer
    embedding_layer_books = Embedding(book_id + 1,10)(books_input)#Embedding layer
    embedding_output_books = Flatten()(embedding_layer_books)#Embedding layer output

    #Embedding layer for users
    users_input = Input(shape=[1])#1st Input Layer
    embedding_layer_users = Embedding(user_id + 1,10)(users_input)#Embedding layer
    embedding_output_users = Flatten()(embedding_layer_users)#Embedding layer output

    #Concatination and Dense layer

    joining_layer = Concatenate()([embedding_output_books, embedding_output_users])
    hidden_layer_1 = Dense(128, activation='relu')(joining_layer)
    hidden_layer_1 = Dropout(0.5)(hidden_layer_1)

    output_layer = hidden_layer_2 = Dense(1)(hidden_layer_1)

    model = tf.keras.Model([books_input, users_input], output_layer)

    #Model compilation
    optimizer = Adam(lr=0.001, epsilon = 1e-6, amsgrad=True) #epsilon = decay rate
    model.compile(optimizer = optimizer, loss = 'mean_squared_error')#Using mean squared error as loss function
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")
    print(model.summary())
    print("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~")

    #Training model
    early_stopping = EarlyStopping(monitor = 'val_loss', patience = 1)

    print(model.fit(
        [train.book_id, train.user_id], train.rating, 
        batch_size=64, 
        epochs=5, 
        verbose=1,
        callbacks = [early_stopping],
        validation_data=([test.book_id, test.user_id], test.rating)))

    #Saving the model
    model.save('model.h5')