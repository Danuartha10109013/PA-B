<!DOCTYPE html>
<html>

<head>
    <title>Pengajuan Cuti || Pegawai</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: #f6f8fa;
            font-family: 'Inter', Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 72, 100, .12);
            border: none;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(60, 72, 100, .15);
        }

        .card-header {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            font-weight: 600;
            font-size: 1.3rem;
            letter-spacing: 1px;
            padding: 1.5rem;
        }

        #calendar {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(60, 72, 100, .08);
            transition: all 0.3s ease;
        }

        #calendar:hover {
            box-shadow: 0 4px 20px rgba(60, 72, 100, .12);
        }

        .fc-toolbar {
            margin-bottom: 1.5rem !important;
        }

        .fc-button {
            background-color: #5D87FF !important;
            border: none !important;
            border-radius: 6px !important;
            color: #fff !important;
            font-weight: 500 !important;
            margin: 0 2px !important;
            transition: all 0.3s ease;
            padding: 8px 16px;
        }

        .fc-button:hover,
        .fc-button:focus {
            background-color: #3b6fd8 !important;
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(93, 135, 255, 0.3);
        }

        .fc-today {
            background: #e8f0fe !important;
        }

        .fc-event {
            border-radius: 6px !important;
            padding: 4px 8px !important;
            font-size: 0.95rem;
            border: none !important;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .08);
            transition: all 0.3s ease;
        }

        .fc-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(60, 72, 100, .12);
        }

        .fc-event.orange {
            background: #ffb347 !important;
            color: #fff !important;
        }

        .fc-event.green {
            background: #4caf50 !important;
            color: #fff !important;
        }

        .fc-event.red {
            background: #e74c3c !important;
            color: #fff !important;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #3b6fd8;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(93, 135, 255, 0.3);
        }

        .btn-back {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(93, 135, 255, 0.2);
        }

        .btn-back:hover {
            background: #3b6fd8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(93, 135, 255, 0.3);
        }

        .btn-back i {
            margin-right: 8px;
        }

        .saldo-cuti-container {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            color: white;
            border-radius: 12px;
            padding: 15px 20px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(93, 135, 255, 0.15);
            transition: all 0.3s ease;
        }

        .saldo-cuti-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(93, 135, 255, 0.2);
        }

        .saldo-cuti-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .saldo-cuti-value {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .modal-header {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            color: white;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #5D87FF;
            box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.2);
            transform: translateY(-2px);
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-select:focus {
            border-color: #5D87FF;
            box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Animasi untuk event */
        .fc-event {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Efek hover untuk tombol di kalender */
        .fc-button-group button {
            transition: all 0.3s ease;
        }

        .fc-button-group button:hover {
            transform: translateY(-2px);
        }

        /* Styling untuk event yang sedang dipilih */
        .fc-event.fc-selected {
            box-shadow: 0 0 0 2px #5D87FF;
        }

        /* Styling untuk header kalender */
        .fc-header-toolbar {
            padding: 10px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 20px !important;
        }

        /* Styling untuk sel tanggal */
        .fc-day {
            transition: all 0.3s ease;
        }

        .fc-day:hover {
            background-color: #f8fafc;
        }

        /* Styling untuk tombol submit di modal */
        .btn-submit {
            background: linear-gradient(90deg, #5D87FF 0%, #8BBFFF 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(93, 135, 255, 0.2);
            width: 100%;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #3b6fd8;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(93, 135, 255, 0.3);
        }

        /* Styling untuk pesan error */
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 5px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Styling untuk loading state */
        .loading {
            position: relative;
            opacity: 0.7;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 30px;
            margin: -15px 0 0 -15px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #5D87FF;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="{{ route('pegawai.cuti') }}" class="btn btn-back mt-5 animate__animated animate__fadeIn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="card mt-5 animate__animated animate__fadeInUp">
            <h3 class="card-header p-3">Pengajuan Cuti</h3>
            <div class="card-body">
                <div id='calendar'></div>
                <div class="saldo-cuti-container animate__animated animate__fadeInUp">
                    <div class="saldo-cuti-label">Sisa Cuti</div>
                    <div class="saldo-cuti-value">{{ Auth::user()->saldo_cuti ?? '-' }} Kali</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Event Input -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Ajukan Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Judul Cuti</label>
                            <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="alasanCuti" class="form-label">Alasan Cuti</label>
                            <select class="form-select" id="alasanCuti" name="alasan_cuti" required>
                                <option value="" selected disabled>--Pilih Alasan--</option>
                                <option value="Pernikahan">Pernikahan</option>
                                <option value="Keperluan Keluarga">Keperluan Keluarga</option>
                                <option value="Urusan Pendidikan">Urusan Pendidikan</option>
                                <option value="Relaksasi">Relaksasi/Penyegaran</option>
                                <option value="Liburan">Liburan</option>
                            </select>
                        </div>
                        <input type="hidden" id="eventStart" name="start">
                        <input type="hidden" id="eventEnd" name="end">
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: SITEURL + "/pegawai/cuti/fullcalender",
                displayEventTime: false,
                selectConstraint: {
                    start: moment().startOf('day'), // Mulai dari hari ini
                    end: '2100-12-31' // Tanggal jauh ke depan
                },
                eventRender: function (event, element) {
                    var color;
                    // Set the color based on the status
                    if (event.status == 0) {
                        color = 'orange'; // Pending
                    } else if (event.status == 1) {
                        color = 'green'; // Approved
                    } else if (event.status == 2) {
                        color = 'red'; // Rejected
                    }

                    // Apply the color to the event background
                    element.css('background-color', color);

                    // Add user name to event title if available
                    if (event.user_name) {
                        element.find('.fc-title').prepend(event.user_name + " - ");
                    }

                    // Add tooltip
                    element.attr('title', event.title);
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    $('#eventStart').val(moment(start).utc().format("YYYY-MM-DD"));
                    $('#eventEnd').val(moment(end).utc().subtract(1, 'days').format("YYYY-MM-DD"));
                    $('#eventModal').modal('show');
                },
                eventDrop: function (event) {
                    var start = moment(event.start).utc().format("YYYY-MM-DD");
                    var end = moment(event.end).utc().add(1, 'days').format("YYYY-MM-DD"); // Add one day to fix the end date issue

                    // Add loading state
                    $('#calendar').addClass('loading');

                    $.ajax({
                        url: SITEURL + '/pegawai/cuti/fullcalenderAjax',
                        data: {
                            title: event.title,
                            start: start,
                            end: end,
                            id: event.id,
                            type: 'update'
                        },
                        type: "POST",
                        success: function () {
                            $('#calendar').removeClass('loading');
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Event berhasil diperbarui.',
                                icon: 'success',
                                confirmButtonColor: '#5D87FF'
                            });
                        },
                        error: function (xhr) {
                            $('#calendar').removeClass('loading');
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON.error,
                                icon: 'error',
                                confirmButtonColor: '#5D87FF'
                            });
                        }
                    });
                },
                eventClick: function (event) {
                    if (event.status == 1) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Event ini tidak dapat dihapus karena sudah disetujui.',
                            icon: 'error',
                            confirmButtonColor: '#5D87FF'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Apakah Anda ingin menghapus event ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#5D87FF',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Add loading state
                            $('#calendar').addClass('loading');

                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/pegawai/cuti/fullcalenderAjax',
                                data: {
                                    id: event.id,
                                    type: 'delete'
                                },
                                success: function () {
                                    $('#calendar').removeClass('loading');
                                    $('#calendar').fullCalendar('removeEvents', event.id);
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: 'Event Anda telah dihapus.',
                                        icon: 'success',
                                        confirmButtonColor: '#5D87FF'
                                    });
                                },
                                error: function (xhr) {
                                    $('#calendar').removeClass('loading');
                                    Swal.fire({
                                        title: 'Error!',
                                        text: xhr.responseJSON.error,
                                        icon: 'error',
                                        confirmButtonColor: '#5D87FF'
                                    });
                                }
                            });
                        }
                    });
                }
            });

            $('#eventForm').on('submit', function (e) {
                e.preventDefault();
                var title = $('#eventTitle').val();
                var start = $('#eventStart').val();
                var end = $('#eventEnd').val();
                var alasanCuti = $('#alasanCuti').val();

                // Add loading state
                $('#calendar').addClass('loading');

                $.ajax({
                    url: SITEURL + "/pegawai/cuti/fullcalenderAjax",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        alasan_cuti: alasanCuti,
                        type: 'add'
                    },
                    type: "POST",
                    success: function (data) {
                        $('#calendar').removeClass('loading');
                        $('#eventModal').modal('hide');
                        $('#eventForm')[0].reset();
                        calendar.fullCalendar('renderEvent', {
                            id: data.id,
                            title: title,
                            start: start,
                            end: moment(end).add(1, 'days').format("YYYY-MM-DD"),
                            allDay: true,
                            status: 0
                        }, true);
                        calendar.fullCalendar('unselect');
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Event berhasil dibuat',
                            icon: 'success',
                            confirmButtonColor: '#5D87FF'
                        });
                    },
                    error: function (xhr) {
                        $('#calendar').removeClass('loading');
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.error,
                            icon: 'error',
                            confirmButtonColor: '#5D87FF'
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>