from numpy import *
from scipy import optimize
import csv


# a function that normalizes a data set
def normalize_ratings(ratings, did_rate):
    num_games = ratings.shape[0]

    ratings_mean = zeros(shape=(num_games, 1))
    ratings_norm = zeros(shape=ratings.shape)

    for i in range(num_games):
        # get all the indexes where there is a 1
        idx = where(did_rate[i] == 1)[0]
        # calculate mean rating of ith movie only from user's that gave a rating
        ratings_mean[i] = mean(ratings[i, idx])
        ratings_norm[i, idx] = ratings[i, idx] - ratings_mean[i]

    return ratings_norm, ratings_mean


def unroll_params(x_and_theta, num_users, num_games, num_features):
    # Retrieve the X and theta matrices from X_and_theta, based on their dimensions
    # (num_features, num_movies, num_movies)
    # --------------------------------------------------------------------------------------------------------------
    # Get the first 30 (10 * 3) rows in the 48 X 1 column vector
    features_movies = x_and_theta[:num_features * num_games]
    # Reshape this column vector into a 10 X 3 matrix
    x = features_movies.reshape((num_features, num_games)).transpose()
    # Get the rest of the 18 the numbers, after the first 30
    features_users = x_and_theta[num_features * num_games:]
    # Reshape this column vector into a 6 X 3 matrix
    theta = features_users.reshape(num_features, num_users ).transpose()
    return x, theta


def calculate_gradient(x_and_theta, ratings, did_rate, num_users, num_games, num_features, reg_param):
    x, theta = unroll_params(x_and_theta, num_users, num_games, num_features)

    # we multiply by did_rate because we only want to consider observations for which a rating was given
    difference = x.dot(theta.T) * did_rate - ratings
    x_grad = difference.dot(theta) + reg_param * x
    theta_grad = difference.T.dot(x) + reg_param * theta

    # wrap the gradients back into a column vector
    return r_[x_grad.T.flatten(), theta_grad.T.flatten()]


def calculate_cost(x_and_theta, ratings, did_rate, num_users, num_games, num_features, reg_param):
    x, theta = unroll_params(x_and_theta, num_users, num_games, num_features)

    # we multiply (element-wise) by did_rate because we only want to consider observations for which a rating was given
    cost = sum((x.dot(theta.T) * did_rate - ratings) ** 2) / 2
    # '**' means an element-wise power
    # the following line is to prevent overfeeding
    regularization = (reg_param / 2) * (sum(theta ** 2) + sum(x ** 2))
    return cost + regularization


def get_game_name(datafile):
    with open(datafile, mode='r') as infile:
        reader = csv.reader(infile)
        dict = {}
        i = 0
        for rows in reader:
            dict[i] = rows[1]
            i += 1
        #dict = {rows[0]: rows[1] for rows in reader}
        return dict


# 0. NBA 2K17 (Xbox One)
# 1. Guitar Hero Supreme Party Edition Bundle with 2 Gu...
# 2. Forza Horizon 3 (Xbox One)
# 3. Mortal Kombat X (Xbox One)
# 4. Watch Dogs 2 - Xbox One
# 5. ROCKET LEAGUE (Xbox One)
# 6. Minecraft (Xbox One)
# 7. Madden NFL 17 - Xbox One
# 8. Halo 5: Guardians (Xbox One)
# 9. Farming Simulator 17 - Xbox One
game_name_file = 'GameNames.csv'
game_names = get_game_name(game_name_file)

# user id: 7, 9, 11-22, 24-39
num_users = 31
num_games = 200 #len(dict)
num_features = 3

# features: action, adventure, role-playing, simulation, strategy, and sports

# get rating from database
ratings = genfromtxt('UserProductRatingScore.csv', delimiter=',')[:num_games * num_users].reshape(num_games, num_users)

# 0 means that movie has no rating
did_rate = (ratings != 0) * 1

# enter information for new user
new_user_game_ratings = zeros((num_games, 1))
new_user_game_ratings[0] = 3
new_user_game_ratings[1] = 5
new_user_game_ratings[3] = 1
new_user_game_ratings[8] = 8

# add movie_ratings to ratings as an extra column
ratings = append(new_user_game_ratings, ratings, axis=1)
did_rate = append(((new_user_game_ratings != 0) * 1), did_rate, axis=1)

# normalize data set
ratings, ratings_mean = normalize_ratings(ratings, did_rate)
num_users = ratings.shape[1]

# create the matrix for game features
game_features = random.randn(num_games, num_features)

# create the matrix for user preferences
user_prefs = random.randn(num_users, num_features)

initial_x_and_theta = r_[game_features.T.flatten(), user_prefs.T.flatten()]

# perform gradient descent, find the minimum cost (sum of squared errors) and optimal values of
# x (movie_features) and Theta (user_prefs)
reg_param = 30
minimized_cost_and_optimal_params = optimize.fmin_cg(calculate_cost, fprime=calculate_gradient,
                                                     x0=initial_x_and_theta,
                                                     args=(ratings, did_rate, num_users, num_games, num_features,
                                                           reg_param),
                                                     maxiter=100, disp=True, full_output=True)

optimal_game_features_and_user_prefs = minimized_cost_and_optimal_params[0]
cost = minimized_cost_and_optimal_params[1]
game_features, user_prefs = unroll_params(optimal_game_features_and_user_prefs, num_users, num_games, num_features)

# Make some predictions (movie recommendations). Dot product
all_predictions = game_features.dot(user_prefs.T)

# add back the ratings_mean column vector to my (our) predictions
predictions_for_games = all_predictions[:, 0:1] + ratings_mean
sorted_indexes = predictions_for_games.argsort(axis=0)[::-1]
predictions_for_games = predictions_for_games[sorted_indexes]

print game_names[asscalar(sorted_indexes[0])]
