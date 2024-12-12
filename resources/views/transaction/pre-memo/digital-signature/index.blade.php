@extends('layouts.app')

@section('title')
    Verifikasi Digital Signature Memo Kainst
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/zxing/index.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let selectedDeviceId;
            const codeReader = new ZXing.BrowserQRCodeReader();

            codeReader.getVideoInputDevices()
                .then((videoInputDevices) => {
                    const sourceSelect = document.getElementById('sourceSelect')
                    selectedDeviceId = videoInputDevices[0].deviceId

                    if (videoInputDevices.length >= 1) {
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option')
                            sourceOption.text = element.label
                            sourceOption.value = element.deviceId
                            sourceSelect.appendChild(sourceOption)
                        })

                        sourceSelect.onchange = () => {
                            selectedDeviceId = sourceSelect.value;
                        };

                        const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                        sourceSelectPanel.style.display = 'block'
                    }
                })
                .catch((err) => {
                    console.error(err)
                })

            $('#scanModal').on('shown.bs.modal', function(e) {
                codeReader.reset()

                decodeOnce(codeReader, selectedDeviceId);
            })

            $('#scanModal').on('hide.bs.modal', function(e) {
                codeReader.reset()
            })
        });

        const decodeOnce = (codeReader, selectedDeviceId) => {
            codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
                document.getElementById('signature').textContent = result.text

                $('#scanModal').modal('hide')
            })
        }
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verifikasi</h5>
                        <form class="row g-3" action="{{ route('digital-signature.pre-memo.verify') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="number_transaction" class="form-label">Nomer Transaksi</label>
                                <select id="number_transaction" name="number_transaction"
                                    class="form-select {{ $errors->has('number_transaction') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Nomer Transaksi</option>
                                    @foreach ($memos as $memo)
                                        <option value="{{ $memo->number_transaction }}">
                                            {{ $memo->number_transaction }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('number_transaction')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="signature" class="form-label">Signature</label>
                                <textarea class="form-control {{ $errors->has('signature') ? 'border border-danger' : '' }}" name="signature"
                                    id="signature" cols="15" rows="5" aria-hidden="false"></textarea>
                                @error('signature')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                    data-bs-target="#scanModal">
                                    Scan Signature
                                </button>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="scanModalLabel">Scan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 mb-2" id="sourceSelectPanel" style="display: none;">
                            <select class="form-control" name="sourceSelect" id="sourceSelect">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <video id="video" style="width: 100%;"></video>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
