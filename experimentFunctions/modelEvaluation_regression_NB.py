import pandas as pd
import numpy as np
import sys

dataset = pd.read_json('features.json') #read the json file from Kawan server

num_of_features = 5;

X = dataset.iloc[:, 0:num_of_features].values #set features range
y = dataset.iloc[:, num_of_features].values #set attributes range

from sklearn.model_selection import train_test_split

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=0)

# Feature Scaling
from sklearn.preprocessing import StandardScaler

sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)

from sklearn.naive_bayes import GaussianNB
clf = GaussianNB()
clf.fit(X_train, y_train)
y_pred = clf.predict(X_test)

from sklearn import metrics

print('Mean Absolute Error:', metrics.mean_absolute_error(y_test, y_pred))
print('Mean Squared Error:', metrics.mean_squared_error(y_test, y_pred))
print('Root Mean Squared Error:', np.sqrt(metrics.mean_squared_error(y_test, y_pred)))

from sklearn.metrics import classification_report, accuracy_score

y_pred = np.rint(y_pred)
i = 0
for pred in y_pred:
    y_pred[i] = int(pred)
    i += 1

print("Accuracy Score:", accuracy_score(y_test, y_pred))