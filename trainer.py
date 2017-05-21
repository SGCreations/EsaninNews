import sklearn
from termcolor import colored
from textblob.classifiers import NaiveBayesClassifier
from textblob import TextBlob
import cPickle as pickle
import sys
from os import listdir
from os.path import isfile, join
import nltk, collections

# Define variables
train_set = []
root_path = "dataset_"


def train_dataset(category):
    try:
        #Path to the dataset
        path = root_path + category

        files_in_path = [f for f in listdir(path) if isfile(join(path, f))]

        #Loop through the dataset and extract nouns
        for i in files_in_path:
            with open(path + "/" + i, 'r') as content_file:
                content = content_file.read().decode("utf8", 'ignore')
                is_noun = lambda pos: pos[:2] == 'NN'
                tokenized = nltk.word_tokenize(content)
                nouns = [word for (word, pos) in nltk.pos_tag(tokenized) if is_noun(pos)]
                counter = collections.Counter(nouns)
                popular_words = sorted(counter, key=counter.get, reverse=True)
                top_count = popular_words[:5]
                top_count = set(top_count)
                for j in top_count:
                    train_set.append((j, category))
    except Exception as e:
        print(e)
        return

def combine_datasets(train_set):
    final_train_set = set(train_set)
    return final_train_set

def extract_all():
    train_dataset("politics")
    train_dataset("business")
    train_dataset("entertainment")
    train_dataset("sports")
    train_dataset("technology")

def train_all(train_set):
    extract_all()
    final_train_set = combine_datasets(train_set)
    cl = NaiveBayesClassifier(final_train_set)
    pickle.dump(cl, open('model.pkl', 'wb'))

train_all(train_set)
print "Training complete..."

