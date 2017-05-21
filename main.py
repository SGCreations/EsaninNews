'''
Esanin News
Created By: Sidath Gajanayaka
Date: 10th of April 2017
Last edited date: 25th of April 2017
(C) All rights reserved.
'''

# -*- coding: utf-8 -*-
import json
import sys
from flask import Flask
from flask import request
from flask_cors import CORS

reload(sys)
sys.setdefaultencoding('utf8')

# Defining Flask server
app = Flask(__name__)
app.config['SECRET_KEY'] = 'the quick brown fox jumps over the lazy   dog'
app.config['CORS_HEADERS'] = 'Content-Type'
CORS(app)


@app.route("/getNews", methods=['POST', 'GET'])
def getNews():
    printLog('info', '=========Client request received=========')
    try:
        return_list = []
        import crawler
        printLog('info', '=========Receiving news from URLs=========')
        news_list = crawler.getNews()
        printLog('info', 'Received ' + str(len(news_list)) + ' news items...')
        for i in news_list:
            import classifier
            printLog('process', 'Classifying...')
            classified = classifier.classify_input(i, False)
            printLog('info', 'Classification done: ' + classified)
            return_list.append([i, classified])
        json_string = json.dumps(return_list)
        print len(return_list)
        printLog('info', '=========REQUEST COMPLETED=========')
        return json_string
    except Exception as e:
        printLog('error', e)


@app.route('/classify', methods=['GET'])
def classify():
    printLog('info', '=========Client request received=========')
    try:
        textToClassify = request.args["textToClassify"]
        import classifier
        printLog('process', 'Classifying...')
        classified = classifier.classify_input(textToClassify, False)
        printLog('info', 'Classification done: ' + classified)
        printLog('info', '=========REQUEST COMPLETED=========')
        return classified
    except Exception as e:
        printLog('error', e)


@app.route('/classifyUser', methods=['GET'])
def classifyUser():
    printLog('info', '=========Client request received=========')
    try:
        textToClassify = request.args["textToClassify"]
        category = request.args["category"]
        import classifier
        printLog('process', 'Adding classification: ' + category.lower() + ' to dataset...')
        classifier.classify_input(textToClassify, True, category.lower())
        printLog('info', 'File created...')
        printLog('info', '=========REQUEST COMPLETED=========')
        return "Done"
    except Exception as e:
        printLog('error', e)


def printLog(level, message):
    if level == 'info':
        print "[INFO]: ", message
    elif level == 'error':
        print "[ERROR]: ", message
    elif level == 'process':
        print "[PROCESS]: ", message


if __name__ == "__main__":
    try:
        app.run(host='0.0.0.0', debug=True, port=3030)
    except Exception as e:
        print(e)
