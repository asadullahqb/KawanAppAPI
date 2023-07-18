import pandas as pd
import numpy as np
import sys
import pickle

try:
    dataset = pd.read_json('predict_features.json') #read the json file from Kawan server

    X = dataset.iloc[:, 0:3].values #set features range
    y = dataset.iloc[:, 3].values #set attributes range

    X_train = X
    y_train = y

    # Feature Scaling
    from sklearn.preprocessing import StandardScaler

    sc = StandardScaler()
    X_train = sc.fit_transform(X_train)

    from sklearn.ensemble import RandomForestRegressor

    regressor = RandomForestRegressor(n_estimators=20, random_state=0)
    regressor.fit(X_train, y_train)

    filename = 'predict_trainedModel.sav'
    pickle.dump(regressor, open(filename, 'wb'))
    print(True)
except:
    print(False)