import requests
import time
import mysql.connector
import os
from dotenv import load_dotenv
from pathlib import Path
dotenv_path = Path('./vars.env')
load_dotenv(dotenv_path=dotenv_path)
print(os.getenv('MYSQL_HOST'), os.getenv('MYSQL_USERNAME'), os.getenv('MYSQL_PASSWORD'), os.getenv('MYSQL_DATABASE'))
response = requests.get('https://api.nobitex.ir/v2/orderbook/USDTIRT').json()
print(response)
bids = response["bids"]
asks = response["asks"]

transactions_database = mysql.connector.connect(
    host= os.getenv('MYSQL_HOST'),
    user= os.getenv('MYSQL_USERNAME'),
    password= os.getenv('MYSQL_PASSWORD'),
    database= os.getenv('MYSQL_DATABASE')
)
transactions_cursor = transactions_database.cursor()

sql = """INSERT INTO transactions (type, market, amount, price, cost, fee, time)
VALUES (%(type)s, %(market)s, %(amount)s, %(price)s, %(cost)s, %(fee)s, %(time)s)"""
for bid in bids:
    query = """SELECT * FROM transactions WHERE type = %(type)s 
    AND market = %(market)s 
    AND amount = %(amount)s 
    AND price = %(price)s"""

    transactions_cursor.execute(query, 
    {'type': 'sell', 
    'market': 'USDTIRT', 
    'amount': float(bid[1]), 
    'price': int(int(bid[0]) / 10)})

    if (transactions_cursor.fetchall() == []):
        transactions_cursor.execute(sql, {
        "type": "sell",
        "market": "USDTIRT",
        "amount": float(bid[1]),
        "price": int(int(bid[0]) / 10),
        "cost": int((float(bid[1]) * int(bid[0])) / 10),
        "fee": int((float(bid[1]) * int(bid[0]) * 0.0035) / 10),
        "time": int(time.time())
        })
        transactions_database.commit()
        print('sell row inserted')

for ask in asks:
    query = """SELECT * FROM transactions WHERE type = %(type)s 
    AND market = %(market)s 
    AND amount = %(amount)s 
    AND price = %(price)s"""

    transactions_cursor.execute(query, 
    {'type': 'buy', 
    'market': 'USDTIRT', 
    'amount': float(ask[1]), 
    'price': int(int(ask[0]) / 10)})

    if (transactions_cursor.fetchall() == []):
        transactions_cursor.execute(sql, {
        "type": "buy",
        "market": "USDTIRT",
        "amount": float(ask[1]),
        "price": int(int(ask[0]) / 10),
        "cost": int((float(ask[1]) * int(ask[0])) / 10),
        "fee": int((float(ask[1]) * int(ask[0]) * 0.0035) / 10),
        "time": int(time.time())
        })
        transactions_database.commit()
        print('buy row inserted')
