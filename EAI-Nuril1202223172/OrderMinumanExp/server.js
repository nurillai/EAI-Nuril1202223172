const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

app.use(bodyParser.json());

const db = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'minuman'
});

db.connect(err => {
    if (err) {
        console.error('Database connection failed:', err);
    } else {
        console.log('Connected to MySQL database');
    }
});

app.get('/pesanan', (req, res) => {
    db.query('SELECT * FROM pesanan_minuman', (err, results) => {
        if (err) return res.status(500).json({ status: 'error', message: err.message });
        res.status(200).json({ status: 'success', data: results });
    });
});

app.get('/pesanan/:id', (req, res) => {
    const { id } = req.params;
    db.query('SELECT * FROM pesanan_minuman WHERE id = ?', [id], (err, results) => {
        if (err) return res.status(500).json({ status: 'error', message: err.message });
        if (results.length === 0) return res.status(404).json({ status: 'error', message: 'Pesanan tidak ditemukan' });
        res.status(200).json({ status: 'success', data: results[0] });
    });
});

app.post('/pesanan', (req, res) => {
    const { nama_pemesan, jenis_minuman, suhu, gula } = req.body;
    const query = 'INSERT INTO pesanan_minuman (nama_pemesan, jenis_minuman, suhu, gula) VALUES (?, ?, ?, ?)';
    db.query(query, [nama_pemesan, jenis_minuman, suhu, gula], (err, results) => {
        if (err) return res.status(500).json({ status: 'error', message: err.message });
        res.status(201).json({ status: 'success', message: 'Pesanan berhasil disimpan!', data: { id: results.insertId, nama_pemesan, jenis_minuman, suhu, gula } });
    });
});

app.put('/pesanan/:id', (req, res) => {
    const { id } = req.params;
    const { nama_pemesan, jenis_minuman, suhu, gula } = req.body;
    const query = 'UPDATE pesanan_minuman SET nama_pemesan = ?, jenis_minuman = ?, suhu = ?, gula = ? WHERE id = ?';
    db.query(query, [nama_pemesan, jenis_minuman, suhu, gula, id], (err, results) => {
        if (err) return res.status(500).json({ status: 'error', message: err.message });
        if (results.affectedRows === 0) return res.status(404).json({ status: 'error', message: 'Pesanan tidak ditemukan' });
        res.status(200).json({ status: 'success', message: 'Pesanan berhasil diperbarui!' });
    });
});

app.delete('/pesanan/:id', (req, res) => {
    const { id } = req.params;
    db.query('DELETE FROM pesanan_minuman WHERE id = ?', [id], (err, results) => {
        if (err) return res.status(500).json({ status: 'error', message: err.message });
        if (results.affectedRows === 0) return res.status(404).json({ status: 'error', message: 'Pesanan tidak ditemukan' });
        res.status(200).json({ status: 'success', message: 'Pesanan berhasil dihapus' });
    });
});

app.listen(port, () => {
    console.log(`Server berjalan di http://localhost:${port}`);
});
