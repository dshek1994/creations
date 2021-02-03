#!/usr/bin/env python3

import requests
import json
from datetime import datetime

#Created static variables for API key and Steam ID
API_KEY = "8C2ED19595C298D4B8C257996D95C860"
STEAM_ID = "76561198807547224"

steam_id_list = []

data = []

def steam_api_request(key, steamid):
    #Make two requests, one for intial player and his/her friendslist
    r_player = requests.get('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' + key + '&steamids=' + steamid)
    r_friendslist = requests.get('http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=' + key + '&steamid=' + steamid + '&relationship=friend')

    return r_player, r_friendslist
    # #Grabbing number of friends in player's profile
    # num_friends = len(r_friendslist.json()['friendslist']['friends'])

    # # for i in r.json():
    # #     for x in range(num_friends):
    # #         print(r.json()['friendslist']['friends'][x])
    
    # for x in range(num_friends):
    #     print(r_friendslist.json()['friendslist']['friends'][x])
    #     ts = int(r_friendslist.json()['friendslist']['friends'][x]['friend_since'])
    #     print(datetime.utcfromtimestamp(ts).strftime('%Y-%m-%d %H:%M-%S'))


    # print(r_player.json()['response']['players'][0])

def collect_player_data(player, friendslist):
    #Grab alias of player
    alias = collect_steam_alias(player)

    #Grab steam id of player
    steam_id = collect_steam_id(player)

    #Grab steam avatar of player
    avatar = collect_steam_avatar(player)

    #Grab account creation date of player
    time_created = collect_steam_timecreated(player)

    #Grabbing number of friends in player's profile
    num_friends = collect_num_friends(friendslist)

    #Converts unix timestamp of player to a readable one in %Y-%m-%d %H:%M-%S format
    time_created_conv = convert_unix_timestamp(time_created)

    #Created player data list to collect data
    player_data = []

    #Append all values in getters to the player_data list
    player_data.append(alias)
    player_data.append(steam_id)
    player_data.append(avatar)
    player_data.append(num_friends)
    player_data.append(time_created_conv)

    #Loop and append all steam ids in player's friends list to the main steam_id_list
    #We do this to loop through all those steamids, crawling linearly
    for i in range(num_friends):
        steam_id_list.append(friendslist.json()['friendslist']['friends'][i]['steamid'])
    
    # print(steam_id_list)

    # print(player_data)

    return player_data


    # for i in r.json():
    #     for x in range(num_friends):
    #         print(r.json()['friendslist']['friends'][x])
    
    # for x in range(num_friends):
    #     print(friendslist.json()['friendslist']['friends'][x])
    #     ts = int(friendslist.json()['friendslist']['friends'][x]['friend_since'])
    #     print(datetime.utcfromtimestamp(ts).strftime('%Y-%m-%d %H:%M-%S'))
    # print(collect_steam_id(player))

#Function to crawl through steam profiles and collect basic info
def crawl_steam_profiles():
    steam_id_list.append(STEAM_ID)
    x = 0
    while x < 500:
        player, friendslist = steam_api_request(API_KEY, steam_id_list[x])
        try:
            data.append(collect_player_data(player,friendslist))
            print_data(data)
        except KeyError: #some steam profiles keep friendslist private so we skip over them with a try catch to handle KeyErrors
            pass
            # player, friendslist = steam_api_request(API_KEY, player.json()['response']['players'][0]['steamid'])
            # print(player.json())
        x += 1
    #print_data(data)

#Function collects steam ID of player
def collect_steam_id(player):
    return player.json()['response']['players'][0]['steamid']

#Function collects steam alias of player
def collect_steam_alias(player):
    return player.json()['response']['players'][0]['personaname']

#Function collects account time creation
def collect_steam_timecreated(player):
    return player.json()['response']['players'][0]['timecreated']

#Function collects steam account avatar link
def collect_steam_avatar(player):
    return player.json()['response']['players'][0]['avatar']

#Function collects number of friends on player's account
def collect_num_friends(player):
    return len(player.json()['friendslist']['friends'])

#Function converts unix timestamp to a readable one
def convert_unix_timestamp(ts):
    return datetime.utcfromtimestamp(ts).strftime('%Y-%m-%d %H:%M-%S')

def checkForDuplicates(data_list):
    for elem in data_list:
        if elem in data_list:
            data_list.remove(elem)
        else:
            data_list.append(elem)


#Function prints out data in a readable format in terminal
def print_data(some_data):
    i = 0
    for i in range(len(data)):
        print('Alias:           ' + some_data[i][0])
        print('Steam ID:        ' + some_data[i][1])
        print('Avatar:          ' + some_data[i][2])
        print('Friends:         ' + str(some_data[i][3]))
        print('Account Date:    ' + some_data[i][4])
        print('\n')


crawl_steam_profiles()