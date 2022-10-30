import requests
import json

class GetData:
    def get_nobitex_buy():
        response = requests.get('https://api.nobitex.ir/v2/orderbook/USDTIRT')
        response_body = json.loads(response.text)
        return int(int(response_body['lastTradePrice']) / 10)
    
    def get_ramzinex_buy():
        response = requests.get('https://publicapi.ramzinex.com/exchange/api/v1.0/exchange/pairs/11')
        response_body = json.loads(response.text)
        return int(int(response_body['data']['buy']) / 10)

    def get_ramzinex_sell():
        response = requests.get('https://publicapi.ramzinex.com/exchange/api/v1.0/exchange/pairs/11')
        response_body = json.loads(response.text)
        return int(int(response_body['data']['sell']) / 10)

    def get_arzpaya_buy():
        response = requests.post('https://api.arzpaya.com/public/Price', headers={"Content-Type": "application/json; charset=utf-8"}, data=json.dumps({"SourceType": 1, "CurrencyType": 8, "BaseCurrencyType": 1}))
        response_body = json.loads(response.text)
        return int(response_body['Data']['BuyPrice'])

    def get_arzpaya_sell():
        response = requests.post('https://api.arzpaya.com/public/Price', headers={"Content-Type": "application/json; charset=utf-8"}, data=json.dumps({"SourceType": 1, "CurrencyType": 8, "BaseCurrencyType": 1}))
        response_body = json.loads(response.text)
        return int(response_body['Data']['SellPrice'])

    def get_phinix_buy():
        response = requests.get('https://api.phinix.ir/v1/markets')
        response_body = json.loads(response.text)
        return int(float(response_body['result']['symbols']['USDTTMN']['stats']['bidPrice']))

    def get_phinix_sell():
        response = requests.get('https://api.phinix.ir/v1/markets')
        response_body = json.loads(response.text)
        return int(float(response_body['result']['symbols']['USDTTMN']['stats']['askPrice']))