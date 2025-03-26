from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+pymysql://root:@127.0.0.1:3306/minuman'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class PesananMinuman(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nama_pemesan = db.Column(db.String(100), nullable=False)
    jenis_minuman = db.Column(db.String(50), nullable=False)
    suhu = db.Column(db.String(10), nullable=False)
    gula = db.Column(db.String(10), nullable=False)

    def as_dict(self):
        return {c.name: getattr(self, c.name) for c in self.__table__.columns}

with app.app_context():
    db.create_all()

@app.route('/pesanan', methods=['GET'])
def get_pesanan():
    pesanan = PesananMinuman.query.all()
    return jsonify({'status': 'success', 'data': [p.as_dict() for p in pesanan]}), 200

@app.route('/pesanan/<int:id>', methods=['GET'])
def get_pesanan_by_id(id):
    pesanan = PesananMinuman.query.get(id)
    if not pesanan:
        return jsonify({'status': 'error', 'message': 'Pesanan tidak ditemukan'}), 404
    return jsonify({'status': 'success', 'data': pesanan.as_dict()}), 200

@app.route('/pesanan', methods=['POST'])
def create_pesanan():
    data = request.get_json()
    try:
        new_pesanan = PesananMinuman(
            nama_pemesan=data['nama_pemesan'],
            jenis_minuman=data['jenis_minuman'],
            suhu=data['suhu'],
            gula=data['gula']
        )
        db.session.add(new_pesanan)
        db.session.commit()
        return jsonify({'status': 'success', 'message': 'Pesanan berhasil disimpan!', 'data': new_pesanan.as_dict()}), 201
    except Exception as e:
        return jsonify({'status': 'error', 'message': str(e)}), 400

@app.route('/pesanan/<int:id>', methods=['PUT'])
def update_pesanan(id):
    pesanan = PesananMinuman.query.get(id)
    if not pesanan:
        return jsonify({'status': 'error', 'message': 'Pesanan tidak ditemukan'}), 404
    
    data = request.get_json()
    for key, value in data.items():
        setattr(pesanan, key, value)
    db.session.commit()
    return jsonify({'status': 'success', 'message': 'Pesanan berhasil diperbarui!', 'data': pesanan.as_dict()}), 200

@app.route('/pesanan/<int:id>', methods=['DELETE'])
def delete_pesanan(id):
    pesanan = PesananMinuman.query.get(id)
    if not pesanan:
        return jsonify({'status': 'error', 'message': 'Pesanan tidak ditemukan'}), 404
    
    db.session.delete(pesanan)
    db.session.commit()
    return jsonify({'status': 'success', 'message': 'Pesanan berhasil dihapus'}), 200

if __name__ == '__main__':
    app.run(debug=True)
