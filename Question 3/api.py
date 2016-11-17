from flask import Flask, jsonify, request
import time
import pymysql

app = Flask(__name__)

#START GET ALL		
@app.route('/api/orders/', methods=['GET'])
def getall_orders():
	try:
		db = pymysql.connect(host='localhost', port=3306, user='OMADMIN', passwd='test', db='omdb')
		cur = db.cursor()
		sql = "SELECT id, OrderRef, CustomerCode, OrderDate, OrderType FROM tborders"
		cur.execute(sql)
		rows = {}
		i = 0
		for row in cur:
			order = {}
			order["id"] = row[0]
			order["OrderRef"] = row[1]
			order["CustomerCode"] = row[2]
			order["OrderDate"] = row[3]
			order["OrderType"] = row[4]
			rows[i]= order
			i=i+1
		
		cur.close()
		db.close()
		
		
		return jsonify({'info': rows})
	except Exception as e:
		return jsonify({'msg': 'Method not Found'})
#END GET ALL	

#START GET BY ID
@app.route('/api/orders/<rid>', methods=['GET'])
def get_orders(rid):
	try:

		db = pymysql.connect(host='localhost', port=3306, user='OMADMIN', passwd='test', db='omdb')
		cur = db.cursor(pymysql.cursors.DictCursor)

		sql = "SELECT id, OrderRef, CustomerCode, OrderDate, OrderType FROM tborders WHERE id ='%s'"
		cur.execute(sql % rid)
		for row in cur:
			print()
			 
		cur.close()
		db.close()
		
		return jsonify({'info': row})
	except Exception as e:
		return jsonify({'msg': 'Method not Found'})
#END GET BY ID

#START POST		
@app.route('/api/orders/', methods=['POST'])
def post_orders():
	try:
		OrderRef=request.form['OrderRef']
		CustomerCode=request.form['CustomerCode']
		OrderDate=time.strftime('%Y-%m-%d %H:%M:%S')
		OrderType=request.form['OrderType']
		db = pymysql.connect(host='localhost', port=3306, user='OMADMIN', passwd='test', db='omdb',autocommit=True)
		cur = db.cursor(pymysql.cursors.DictCursor)
		sql = "INSERT INTO tborders(OrderRef, CustomerCode, OrderDate, OrderType) VALUES ('" + OrderRef + "','" + CustomerCode + "','" + OrderDate + "','" + OrderType + "');"
		cur.execute(sql)
		
		sql = "SELECT id, OrderRef, CustomerCode, OrderDate, OrderType FROM tborders ORDER BY id DESC LIMIT 1"
		cur.execute(sql)
		
		for row in cur:
			print()
		
		cur.close()
		db.close()
		
		return jsonify({'info': row})
	except Exception as e:
		return jsonify({'msg': 'Method not Found'})
#END POST

#START PUT		
@app.route('/api/orders/<rid>', methods=['PUT'])
def update_orders(rid):
	try:
		OrderRef=request.headers['OrderRef']
		CustomerCode=request.headers['CustomerCode']
		OrderDate=time.strftime('%Y-%m-%d %H:%M:%S')
		OrderType=request.headers['OrderType']
		db = pymysql.connect(host='localhost', port=3306, user='OMADMIN', passwd='test', db='omdb',autocommit=True)
		cur = db.cursor(pymysql.cursors.DictCursor)
		sql = "UPDATE tborders SET OrderRef='" + OrderRef + "', CustomerCode='" + CustomerCode + "', OrderDate='" + OrderDate + "', OrderType='" + OrderType + "' WHERE id ='%s'"
		cur.execute(sql % rid)
		cur.close()
		db.close()
		
		return jsonify({'info': 'Info updated!!.'})
	except Exception as e:
		return jsonify({'msg': 'Method not Found'})
#END PUT

if __name__ == '__main__':
	app.run()