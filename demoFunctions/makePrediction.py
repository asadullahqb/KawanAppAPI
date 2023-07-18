import pickle
import pandas as pd
import numpy as np
import sys

filename = 'model.sav'
loaded_classifier = pickle.load(open(filename, 'rb'))

data = pd.read_json('userfeatures/'+sys.argv[1]+'.json') #read the training data from Kawan server

num_of_features = 3;

X_test = data

y_pred = loaded_classifier.predict(X_test)

rank_class = y_pred[0]
print (rank_class)