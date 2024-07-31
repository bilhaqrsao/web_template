<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="page-content contact">
        <!-- HEADING PAGE-->
        <div class="heading-page heading-normal heading-project">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <i class="fa fa-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="index.html">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END HEADING PAGE-->
        <!-- CONTACT, STYLE 3-->
        <section class="contact contact-layout style-3">
            <div class="main-contact">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="contact-form" wire:submit.prevent="store()">
                                <div class="heading">
                                    <h3>Kritik & Saran</h3>
                                </div>
                                <div class="input-group">
                                    <div class="input">
                                        <input wire:model="name" type="text" name="name" placeholder="Masukan Nama Anda" class="@error('name') is-invalid @enderror" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input">
                                        <input wire:model="email" type="text" name="email" placeholder="Masukan Email" class="@error('email') is-invalid @enderror" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input">
                                        <input wire:model="telephone" type="text" name="phone" placeholder="Masukan No. Telepon" class="@error('phone') is-invalid @enderror" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input">
                                        <input wire:model="address" type="text" placeholder="Masukan Alamat Anda" class="@error('address') is-invalid @enderror" />
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-area">
                                    <textarea wire:model="messages" placeholder="Masukan Pesan" name="message" class="@error('message') is-invalid @enderror"></textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="action-group">
                                    <button class="au-btn au-btn-orange au-btn-lg" type="submit">Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <div class="heading">
                                    <h3>Kontak Informasi</h3>
                                </div>
                                <div class="subtitle">
                                    <p>
                                        {{ $identitas->description }}
                                    </p>
                                </div>
                                <ul class="contact-list">
                                    <li>
                                        <i class="fa fa-home"></i>{{ $identitas->address }}</li>
                                    <li>
                                        <i class="fa fa-whatsapp"></i>{{ $identitas->whatsapp }}</li>
                                    <li>
                                        <i class="fa fa-phone"></i>{{ $identitas->phone }}</li>
                                    <li>
                                        <i class="fa fa-envelope"></i>{{ $identitas->email }}</li>
                                    <li>
                                        <i class="fa fa-clock-o"></i>Senin - Jumat 08.00 - 16:00</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! $identitas->map !!}
            <style>
                iframe {
                    width: 100%;
                    height: 400px;
                    border: 0;
                }
            </style>
        </section>
        <!-- END CONTACT, STYLE 3-->
    </div>
</div>
