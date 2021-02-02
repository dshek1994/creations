#!/usr/bin/env python3

import requests
import websocket


# r = requests.get('https://finnhub.io/api/v1/search?q=apple&token=c0casvv48v6u6kubmb00')
# print(r.json())

def on_message(ws, message):
    print(message)

def on_error(ws, error):
    print(error)

def on_close(ws):
    print("### closed ###")

def on_open(ws):
    ws.send('{"type":"subscribe","symbol":"AAPL"}')
    ws.send('{"type":"subscribe","symbol":"AMZN"}')
    ws.send('{"type":"subscribe","symbol":"BINANCE:BTCUSDT"}')
    ws.send('{"type":"subscribe","symbol":"IC MARKETS:1"}')

# if __name__ == "__main__":
#     websocket.enableTrace(True)
#     ws = websocket.WebSocketApp("wss://ws.finnhub.io?token=c0casvv48v6u6kubmb00",
#                               on_message = on_message,
#                               on_error = on_error,
#                               on_close = on_close)
#     ws.on_open = on_open
#     ws.run_forever()

websocket.enableTrace(True)
ws = websocket.WebSocketApp("wss://ws.finnhub.io?token=c0casvv48v6u6kubmb00",
							on_message = on_message,
							on_error = on_error,
							on_close = on_close)

ws.on_open = on_open
ws.run_forever`