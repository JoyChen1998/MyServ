from flask import Flask, request
import os
from flask_cors import CORS



app = Flask(__name__)
CORS(app, resources=r'/*')


@app.route('/')
def hello_world():
    return 'hello world'


@app.route('/item', methods=['GET'])
def item():
    name = request.args.get("item")

    print('name= -------> ', name)
    os.system("python run.py -i {}".format(name))
    return 'welcome ' + name


@app.route('/gvalue', methods=['GET'])
def gvalue():
    val = request.args.get("value")
    print('value= ------>', val)
    os.system("python run.py -v {}".format(val))
    return 'get your val' + val

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8888, debug=False)
