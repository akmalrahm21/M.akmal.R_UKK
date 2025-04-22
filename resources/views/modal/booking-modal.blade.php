<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kamar_id" id="modalRoomId">
                <input type="hidden" name="tipe_kamar" id="modalRoomTypeInput">
                <input type="hidden" id="modalRoomPrice">

                <div class="modal-header">
                    <h5 class="modal-title">Pesan Kamar: <span id="modalRoomType"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <img id="modalRoomPhoto" src="" alt="Foto Kamar" class="img-fluid rounded" style="height: 200px; object-fit: cover;">
                            <p class="mt-2"><strong>Tersedia:</strong> <span id="modalRoomAvailable"></span> kamar</p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" name="telepon" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                                <input type="number" name="jumlah_orang" class="form-control" min="1" required>
                            </div>
                            <div class="mb-2">
                                <label for="jumlah_pesan" class="form-label">Jumlah Kamar Dipesan</label>
                                <input type="number" name="jumlah_pesan" id="modalRoomQty" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="checkin" class="form-label">Check-in</label>
                            <input type="date" name="checkin" id="modalCheckin" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="checkout" class="form-label">Check-out</label>
                            <input type="date" name="checkout" id="modalCheckout" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnTriggerPayment">
                        <i class="bi bi-cart-check"></i> Konfirmasi Pesanan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('resepsionis.upload_bukti') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="resepsionis_id" id="modalPaymentId">
                <input type="hidden" name="kamar_id" id="modalRoomId">
                <input type="hidden" name="tipe_kamar" id="modalRoomTypeInput">



                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mt-3">
                        <img src="https://miro.medium.com/v2/resize:fit:789/1*A9YcoX1YxBUsTg7p-P6GBQ.png" alt="Contoh Bukti Pembayaran" class="img-fluid rounded">
                    </div>
                    <div class="mb-3">
                        <p><strong>Total Harga:</strong> Rp <span id="modalTotalPrice">0</span></p>
                    </div>
                    <p>Silakan unggah screenshot bukti pembayaran kamu di bawah ini</p>
                    <div class="mb-3">
                        <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                    </div>
                    <p class="text-danger"><strong>Waktu tersisa untuk mengunggah bukti pembayaran: <span id="countdownTimer">10</span> detik</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>

    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        const modalCheckin = document.getElementById('modalCheckin');
        const modalCheckout = document.getElementById('modalCheckout');

        modalCheckin.min = today;

        modalCheckin.addEventListener('change', function () {
            const checkinDate = new Date(this.value);
            if (!isNaN(checkinDate.getTime())) {
                checkinDate.setDate(checkinDate.getDate() + 1);
                modalCheckout.min = checkinDate.toISOString().split('T')[0];
                modalCheckout.value = modalCheckout.min;
            }
        });

        const bookingModal = document.getElementById('bookingModal');
        bookingModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('modalRoomId').value = btn.dataset.roomId;
            document.getElementById('modalRoomType').innerText = btn.dataset.roomType;
            document.getElementById('modalRoomTypeInput').value = btn.dataset.roomType;
            document.getElementById('modalRoomPhoto').src = btn.dataset.roomPhoto;
            document.getElementById('modalRoomAvailable').innerText = btn.dataset.roomAvailable;

            modalCheckin.value = '';
            modalCheckout.value = '';
            modalCheckout.min = '';
        });
    });

    document.getElementById('btnTriggerPayment').addEventListener('click', function () {
        const bookingForm = document.querySelector('#bookingModal form');

        const formData = new FormData(bookingForm);
        const inputs = [...bookingForm.querySelectorAll('input')];
        const kosong = inputs.some(input => input.value.trim() === '');

        if (kosong) {
            alert("Ada data yang belum lu isi, Silahkan untuk dilengkapi terlebih dahulu.");
            return;
        }

        fetch("{{ route('pesanan.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert("gagal" + data.error);
                return;
            }

            const resepsionisId = data.resepsionis_id;
            if (resepsionisId) {
                bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();

                document.getElementById('modalPaymentId').value = resepsionisId;

                const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            }
        })
        .catch(err => {
            console.error(err);
            alert("⚠️ Gagal kirim data booking, coba lagi.");
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const bookingModal = document.getElementById('bookingModal');
    const paymentModal = document.getElementById('paymentModal');
    const modalTotalPrice = document.getElementById('modalTotalPrice');
    const modalRoomQty = document.getElementById('modalRoomQty');

    bookingModal.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        const roomPrice = btn.dataset.roomPrice;


        document.getElementById('modalRoomPrice').value = roomPrice;
    });

    document.getElementById('btnTriggerPayment').addEventListener('click', function () {
        const roomQty = parseInt(modalRoomQty.value, 10);
        const roomPrice = parseInt(document.getElementById('modalRoomPrice').value, 10);

        if (!isNaN(roomQty) && !isNaN(roomPrice)) {
            const totalPrice = roomQty * roomPrice;
            modalTotalPrice.textContent = totalPrice.toLocaleString('id-ID');
        }


        const paymentModalInstance = new bootstrap.Modal(paymentModal);
        paymentModalInstance.show();
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentModal = document.getElementById('paymentModal');
        const countdownTimer = document.getElementById('countdownTimer');
        const cancelTimeout = 10000;
        let timeoutId;
        let countdownInterval;

        paymentModal.addEventListener('show.bs.modal', function () {
            let timeLeft = cancelTimeout / 1000;
            countdownTimer.textContent = timeLeft;


            countdownInterval = setInterval(() => {
                timeLeft -= 1;
                countdownTimer.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);


            timeoutId = setTimeout(() => {
                const resepsionisId = document.getElementById('modalPaymentId').value;

                if (resepsionisId) {
                    fetch(`/resepsionis/batal/${resepsionisId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pesanan dibatalkan karena tidak ada bukti pembayaran dalam waktu 1 menit.');
                            bootstrap.Modal.getInstance(paymentModal).hide();
                        } else {
                            alert('Gagal membatalkan pesanan.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan saat membatalkan pesanan.');
                    });
                }
            }, cancelTimeout);
        });

        paymentModal.addEventListener('hide.bs.modal', function () {

            clearTimeout(timeoutId);
            clearInterval(countdownInterval);
        });

        const paymentForm = paymentModal.querySelector('form');
        paymentForm.addEventListener('submit', function () {

            clearTimeout(timeoutId);
            clearInterval(countdownInterval);
        });
    });
</script>
