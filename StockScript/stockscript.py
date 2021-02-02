#!/usr/bin/env python3

import websocket
import requests
import json

API_KEY = "8C2ED19595C298D4B8C257996D95C860"
STEAM_ID = "76561198807547224"

r = requests.get('http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=' + API_KEY + '&steamid=' + STEAM_ID + '&relationship=friend')
num_friends = len(r.json()['friendslist']['friends'])

# for i in r.json():
#     for x in range(num_friends):
#         print(r.json()['friendslist']['friends'][x])
    
for x in range(num_friends):
    print(r.json()['friendslist']['friends'][x]['steamid'])

#note to self, create own data array to display information the way I want and crawl through friendslist taking info