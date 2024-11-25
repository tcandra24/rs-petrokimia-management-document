@extends('layouts.app')

@section('title')
    Verifikasi Digital Signature Disposisi
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    {{--  --}}
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verifikasi</h5>
                        <form class="row g-3" action="{{ route('digital-signature.disposition.verify') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="number_transaction" class="form-label">Nomer Transaksi</label>
                                <select id="number_transaction" name="number_transaction"
                                    class="form-select {{ $errors->has('number_transaction') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Nomer Transaksi</option>
                                    @foreach ($dispositions as $disposition)
                                        <option value="{{ $disposition->number_transaction }}">
                                            {{ $disposition->number_transaction }}
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
                                    id="signature" cols="30" rows="10"></textarea>
                                @error('signature')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
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
    </section>
@endsection
