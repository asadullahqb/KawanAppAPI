import pandas as pd
import numpy as np
import sys
import pickle

try:
    dataset = pd.read_json('features.json') #read the json file from Kawan server

    num_of_features = 5;

    X = dataset.iloc[:, 0:num_of_features].values #set features range
    y = dataset.iloc[:, num_of_features].values #set attributes range

    from sklearn.model_selection import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=0)

    # Feature Scaling
    #from sklearn.preprocessing import StandardScaler

    #sc = StandardScaler()
    #X_train = sc.fit_transform(X_train)

    from sklearn.naive_bayes import MultinomialNB
    clf = MultinomialNB()
    clf.fit(X_train, y_train)

    filename = 'model_classification_nb.sav'
    pickle.dump(clf, open(filename, 'wb'))
    print(True)
    
except:
    print(False)