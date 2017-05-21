# -*- coding: utf-8 -*-
'''
Esanin News
Created By: Sidath Gajanayaka, Heshan Molligoda
Date: 10th of April 2017
Last edited date: 25th of April 2017
(C) All rights reserved.
'''

import cPickle as pickle
import random

root_path = "dataset_"

def classify_input(text_to_classify, add_to_dataset, category=None):

    #Load dataset model
    cl = pickle.load(open("model.pkl", "rb"))
    text_to_classify_formatted = text_to_classify.replace("“", '"').replace("”", '"').replace("’", "'").strip()

    #Classify
    result = cl.classify(text_to_classify_formatted)

    # Adding to dataset under specified category
    if add_to_dataset and category != None:
        rand_val = random.randint(1, 101)
        file_to_save = category + "_" + str(rand_val) + ".txt"
        printLog('process', 'Creating file: ' + file_to_save)
        with open(root_path + category + "/" + file_to_save, "w") as f:
            f.write(text_to_classify)
    return result


def printLog(level, message):
    if level == 'info':
        print "[INFO]: ", message
    elif level=='error':
        print "[ERROR]: ", message
    elif level == 'process':
        print "[PROCESS]: ", message
    elif level == 'output':
        print "[OUTPUT]: ", message