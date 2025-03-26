<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Form Pesanan</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center mb-4">Pesan Minuman</h2>
        <form id="orderForm">
            @csrf
            <label class="block mb-2">Nama Pemesan</label>
            <input type="text" name="nama_pemesan" class="w-full p-2 border rounded mb-4" required>
            
            <label class="block mb-2">Jenis Minuman</label>
            <select name="jenis_minuman" class="w-full p-2 border rounded mb-4" required>
                <option value="">Pilih Minuman</option>
                <option value="Thai Tea">Thai Tea</option>
                <option value="Green Tea">Green Tea</option>
                <option value="Milk Tea">Milk Tea</option>
                <option value="Dark Choco">Dark Choco</option>
                <option value="Vanilla Latte">Vanilla Latte</option>
                <option value="Mocca Latte">Mocca Latte</option>
                <option value="Mango Yakult">Mango Yakult</option>
                <option value="Lychee Tea">Lychee Tea</option>
                <option value="Peach Tea">Peach Tea</option>
            </select>
            <label class="block mb-2">Tingkat Gula</label>
            <select name="gula" class="w-full p-2 border rounded mb-4" required>
                <option value="">Pilih Gula</option>
                <option value="25%">25%</option>
                <option value="50%">50%</option>
                <option value="100%">100%</option>
            </select>
            
            <label class="block mb-2 text-center">Suhu Minuman</label>
<div class="flex justify-center gap-10 mb-4">
    <label class="flex items-center gap-2">
        <input type="checkbox" name="suhu" value="Hot" class="suhu-checkbox"> Hot
    </label>
    <label class="flex items-center gap-2">
        <input type="checkbox" name="suhu" value="Ice" class="suhu-checkbox"> Ice
    </label>
</div>
            
            
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Pesan Sekarang</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.suhu-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                document.querySelectorAll('.suhu-checkbox').forEach(cb => {
                    if (cb !== this) cb.checked = false;
                });
            });
        });

        document.getElementById('orderForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('{{ route("pesanan.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                alert(result.message);
                event.target.reset();
            } catch (error) {
                alert(error.message);
            }
        });
    </script>
</body>
</html>
