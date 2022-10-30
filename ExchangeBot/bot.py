from GetData import *

choice = input("Choose Your Action:\n1.Buy\n2.Sell\n")

if (choice == '1'):
    buy = {
        'Ramzinex': GetData.get_ramzinex_buy(),
        'Arzpaya': GetData.get_arzpaya_buy(),
        'Phinix': GetData.get_phinix_buy()
    }
    print("Buy "+next(iter(sorted(buy.items(), key=lambda x: x[1], reverse=True)))[0] + ': ' + str(next(iter(sorted(buy.items(), key=lambda x: x[1], reverse=True)))[1]) + ' T')
else:
    sell = {
    'Ramzinex': GetData.get_ramzinex_sell(),
    'Arzpaya': GetData.get_arzpaya_sell(),
    'Phinix': GetData.get_phinix_sell()
    }
    print("Sell " + next(iter(sorted(sell.items(), key=lambda x: x[1])))[0] + ': ' + str(next(iter(sorted(sell.items(), key=lambda x: x[1])))[1]) + ' T')
