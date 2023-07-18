import pickle
import pandas as pd
import numpy as np
import sys

filename = 'predict_trainedModel.sav'
loaded_regressor = pickle.load(open(filename, 'rb'))

dataset = pd.read_json('predict_features.json') #read all features to use for scaling of the prediction features.
data = pd.read_json('userfeatures/'+sys.argv[1]+'.json') #read the training data from Kawan server

X = dataset.iloc[:, 0:3].values #set features range

X_train = X
X_test = data

from sklearn.preprocessing import StandardScaler

sc = StandardScaler()

X_train = sc.fit_transform(X_train) #training data is used to fit transform for the test data
X_test = sc.transform(X_test)

y_pred = loaded_regressor.predict(X_test)

integer_ranking = int(round(y_pred[0]))
print (integer_ranking)