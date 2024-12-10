from flask import Flask, render_template, request, redirect, url_for, session
import mysql.connector
from mysql.connector import Error 

app = Flask(__name__)
app.secret_key = "your_secret_key"  

# Database connection setup
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="tesl"
)
cursor = db.cursor()

@app.route("/", methods=["GET"])
def index():
    # Rendering index.html (main page)
    return render_template("index.html")

if __name__ == "__main__":
    app.run(debug=True)