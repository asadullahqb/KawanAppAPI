import pandas as pd
import numpy as np
import sys
import pickle

try:
    dataset = pd.read_json('features.json') #read the json file from Kawan server

    num_of_features = 3;
    
    X = dataset.iloc[:, 0:num_of_features].values #set features range
    y = dataset.iloc[:, num_of_features].values #set attributes range

    from sklearn.model_selection import train_test_split

    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=0)

    # Feature Scaling
    from sklearn.preprocessing import StandardScaler

    sc = StandardScaler()
    X_train = sc.fit_transform(X_train)

    from sklearn.ensemble import RandomForestClassifier 
    
    trees = 200
    r = 0

    classifier = RandomForestClassifier(n_estimators=trees, random_state=r)
    classifier.fit(X_train, y_train)
    
    filename = 'model.sav'
    pickle.dump(classifier, open(filename, 'wb'))
    print(True)

except Exception as e: 
    print(e)
    print(False)