from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/get_secure_url', methods=['GET'])
def get_secure_url():
    key = request.args.get('key')
    if not key:
        return jsonify({'error': 'No key provided'}), 400
    
    # Construct the secure URL
    secure_url = f"https://pw.pwjarvis.tech/?v={key}.m3u8"
    
    return jsonify({'secure_url': secure_url})

if __name__ == '__main__':
    app.run(debug=True)
