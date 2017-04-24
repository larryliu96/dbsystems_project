from __future__ import print_function
import numpy as np
#from scipy import stats
import pandas as pd
import matplotlib.pyplot as plt
import statsmodels.api as sm
import json
#from statsmodels.graphics.api import qqplot
import csv
import datetime as dt
from scipy import special
import datetime

# forecasting, time series model, predictive scoring, forecasting analysis, predicitve decision: models

#1. check if most recent data point is a sale
#2. if sale, return "BUY" with confidence of 100%
#3. if not sale:
#	4. calculate rolling averages (weighted?) of items in the past
#		rolling averages should have been preprocessed
#		put in HistoricalData table: r_avg_1, r_avg_2, r_avg_3, r_avg_4, r_avg_5
#	5. check if

#Other considerations:
#Median?
#Graph the rolling averages? 

with open('HistoricalData.csv', 'r') as original: data = original.read()
#with open('HistoricalData.csv', 'w') as modified: modified.write("item_id,date,price\n" + data)

#with open('test.txt', 'w') as f:
#	f.write("hey")

dta = []
df = []
dta = pd.read_csv('HistoricalData.csv')

#dta.to_csv("original_data.csv", index = False, encoding = 'utf-8')
date = dta.date
del dta['item_id']
#orig = dta.to_json(orient='records')[1:-1]
#with open('original_data.txt', 'w') as f:
#    f.write("var jsondata =[")
#with open('original_data.txt', 'a') as f:
#    f.write(orig)
#with open('original_data.txt', 'a') as f:
#    f.write(']')


del dta['date']
dta.index = pd.Index(date)
dta.tail()

dta_t = special.boxcox(dta['price'], -0.2)
res_s = sm.tsa.SARIMAX(dta_t, order=(1, 1, 1), seasonal_order=(0, 1, 1, 12)).fit()
#res_s.summary().tables[1]

pred = res_s.get_prediction(start='2017-03-10', end='2017-04-30')
pred_ci = pred.conf_int()

#fig, ax = plt.subplots()

pred_ci_orig = special.inv_boxcox(pred.conf_int(), -0.2)

forecast = special.inv_boxcox(pred.predicted_mean, -0.2)
forecast_df = pd.DataFrame({'date':forecast.index, 'forecasted price':forecast.values})

forecast_date = forecast_df.date
del forecast_df['date']
forecast_df.index = pd.Index(forecast_date)

#forecast_df.to_csv("forecast_data.csv", index = False, encoding = 'utf-8')

orig = dict()
for index, row in dta.iterrows():
	#print (str(index))
	orig[str(index)] = [row['price'], None]

#with open("data.txt", "w") as f:
#	for key, value in orig.items():
#		f.write(str(key) + " " + str(value))

for index, row in forecast_df.iterrows():
	idx = str(index.date())
	if idx in orig:
		#print (str(idx) + " IN")
		#print (str(orig[idx][0]))
		orig[idx][1] = row['forecasted price']
	else:
		#print (str(idx) + " OUT")
		orig[idx] = [None,row['forecasted price']]

with open("../../../../data/data.js", "w") as f:
	f.write("var jsondata = [")
	i = 1
	for key, value in orig.items():
		if i == 1:
			i = i + 1
			if value[0] == None:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+  '"forecasted price": ' + '"' + str(value[1]) + '"' + '}')
			elif value[1] == None:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+ '"orig_price": ' + '"' + str(value[0]) + '"' + '}')
			else:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+ '"orig_price": ' + '"' + str(value[0]) + '"' + ',' + '"forecasted price": ' + '"'+ str(value[1]) + '"'+ '}')
		else:
			f.write(",")
			if value[0] == None:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+  '"forecasted price": ' + '"'+str(value[1]) +'"' + '}')
			elif value[1] == None:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+ '"orig_price": ' + '"'+str(value[0]) +'"'+ '}')
			else:
				f.write('{"date": ' + '"' + str(key) + '"' + ','+ '"orig_price": ' + '"'+str(value[0]) + '"'+',' + '"forecasted price": ' + '"'+str(value[1]) +'"'+ '}')
	f.write('];')
	f.write("$(function(){Morris.Line({element: 'predict', data: jsondata, xkey: 'date', ykeys: ['orig_price', 'forecasted price'], labels: ['original price', 'forecasted price'], pointSize: 2, hideHover: 'auto', resize: true, lineColors: ['#4b89ed', '#ff422d']});});")
	#f.write("here")


#with open (data.txt, 'w') as f:
#	f.write(dta.to_json(orient='records')[1:-1])

#date = forecast_df.date
#del forecast_df['date']
#forecast_df.index = pd.Index(date)
#ax1 = forecast_df.plot(label = 'forecast', lw = 3, alpha = 0.7, color = 'r')
#ax1.fill_between(pred_ci_orig.index,
#                pred_ci_orig.iloc[:, 0],
#                pred_ci_orig.iloc[:, 1], color='k', alpha=.15)
#dta.plot(ax = ax1, label = 'historical data', color = '#508bdd')
#ax.set_title('Forecast of future prices', fontsize=16)
#plt.legend(loc = 'best')
#plt.show()
#fig = ax1.get_figure()
#fig.savefig('test.png', bbox_inches='tight')
