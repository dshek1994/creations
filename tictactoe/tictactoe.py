# ----- Global Variables -----

# Game board
board = ["-", "-", "-", 
         "-", "-", "-",
         "-", "-", "-"]

# If game is still going
game_still_going = True

# Who won? Or tie?
winner = None

# Who's turn is it
current_player = "X"

def display_board():
    print(board[0] + " | " + board[1] + " | " + board[2])
    print(board[3] + " | " + board[4] + " | " + board[5])
    print(board[6] + " | " + board[7] + " | " + board[8])

# Play a game of tic tac toe
def play_game():

    # Display initial board
    display_board()

    while game_still_going:

        # handle a single turn of an arbitrary player
        handle_turn(current_player)

        # check if the game has ended
        check_if_game_over()

        # Flip to the other player
        flip_player()
    
    # The game has ended
    if winner == "X" or winner =="O":
        print (winner + " won.")
    elif winner == None:
        print("Tie.")

# Handle a single turn of an arbirtrary player
def handle_turn(player):
    position = input("Choose a position from 1-9: ")
    postion = int(position) - 1

    board[postion] = "X"
    display_board()

def check_if_game_over():
    check_if_win()
    check_if_tie()

def check_if_win():
    # check rows
    # check columns
    #check diagonals
    return

def check_if_tie():
    return

def flip_player():
    return


play_game()