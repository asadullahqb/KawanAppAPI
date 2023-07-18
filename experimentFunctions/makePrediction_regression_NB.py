import pickle
import pandas as pd
import numpy as np
import sys

filename = 'model_regression_nb.sav'
loaded_nb = pickle.load(open(filename, 'rb'))

dataset = pd.read_json('features.json') #read all features to use for scaling of the prediction features.
data = pd.read_json('unifeatures/'+sys.argv[1]+'.json') #read the training data from Kawan server

num_of_features = 5;

X = dataset.iloc[:, 0:num_of_features].values #set features range

X_train = X
X_test = data

from sklearn.preprocessing import StandardScaler

#sc = StandardScaler()

#X_train = sc.fit_transform(X_train) #training data is used to fit transform for the test data
#X_test = sc.transform(X_test)

#No need scaling for Naive Bayes

y_pred = loaded_nb.predict(X_test)

integer_ranking = int(round(y_pred[0]))
print (integer_ranking)