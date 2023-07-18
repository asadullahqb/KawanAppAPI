import pickle
import pandas as pd
import numpy as np
import sys

dataset = pd.read_json('features.json') #read the json file from Kawan server

num_of_features = 3

X = dataset.iloc[:, 0:num_of_features] #set features range
y = dataset.iloc[:, num_of_features] #set attributes range

#Test set is set as 0.25 of the whole dataset
X_train = X.iloc[0:12,:].values
X_test = X.iloc[12:16,:].values
y_test = y.iloc[12:16].values

### Feature scaling makes the model actually less accurate!
# # Feature Scaling
# from sklearn.preprocessing import StandardScaler

# sc = StandardScaler()
# X_train = sc.fit_transform(X_train)
# X_test = sc.transform(X_test)

# Make Prediction
filename = 'model.sav'
loaded_classifier = pickle.load(open(filename, 'rb'))
y_pred = loaded_classifier.predict(X_test)
print(y_test)
print(y_pred)

#Report Prediction Performance
from sklearn.metrics import classification_report, accuracy_score

print(classification_report(y_test,y_pred))
print("Accuracy Score:",accuracy_score(y_test, y_pred))