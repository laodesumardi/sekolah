@extends('layouts.app')

@section('title', 'Kontak - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
                <p class="text-xl text-primary-100">Kami siap membantu dan menjawab pertanyaan Anda</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Informasi Kontak</h2>
                    
                    <div class="space-y-8">

                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                                <p class="text-gray-600">
                                    <a href="{{ $contact->phone_link ?? 'tel:+62911123456' }}" class="hover:text-primary-600 transition-colors">
                                        {{ $contact->phone ?? '(0911) 123456' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                                <p class="text-gray-600">
                                    <a href="{{ $contact->email_link ?? 'mailto:smp01namrole@email.com' }}" class="hover:text-primary-600 transition-colors">
                                        {{ $contact->email ?? 'smp01namrole@email.com' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Website</h3>
                                <p class="text-gray-600">
                                    <a href="{{ $contact->website_link ?? 'https://smpnegeri01namrole.sch.id' }}" class="hover:text-primary-600 transition-colors" target="_blank">
                                        {{ $contact->website ?? 'smpnegeri01namrole.sch.id' }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Kirim Pesan</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form id="contact-form" action="{{ route('contact.store') }}" method="POST" class="space-y-6" data-mobile-action="{{ route('contact.mobile') }}">
                        @csrf
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">
                            Jika di HP muncul error 419, tap tombol "Refresh Token" lalu coba kirim lagi.
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" id="refresh-contact-token" class="px-3 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-md border border-yellow-300 text-sm font-medium">
                                Refresh Token
                            </button>
                            <span id="refresh-status" class="text-xs text-gray-500"></span>
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('subject') border-red-500 @enderror"
                                   placeholder="Masukkan subjek pesan Anda">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('message') border-red-500 @enderror"
                                      placeholder="Tuliskan pesan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full bg-primary-600 text-white py-3 px-6 rounded-lg hover:bg-primary-700 transition-colors font-medium">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>

                    <script>
                        // More aggressive mobile CSRF handling
                        async function refreshContactCSRFToken() {
                            const statusEl = document.getElementById('refresh-status');
                            try {
                                statusEl.textContent = 'Merefresh token...';
                                
                                // Force page reload for mobile to get fresh token
                                const ua = navigator.userAgent || '';
                                const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile/i.test(ua);
                                
                                if (isMobile) {
                                    // For mobile, do a full page refresh to get fresh session
                                    window.location.reload();
                                    return;
                                }
                                
                                const tokenUrl = (window?.location?.origin || '') + '/ppdb/refresh-token';
                                const response = await fetch(tokenUrl, {
                                    method: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                        'Cache-Control': 'no-cache',
                                        'Pragma': 'no-cache'
                                    },
                                    cache: 'no-store',
                                    credentials: 'same-origin',
                                    mode: 'same-origin'
                                });
                                
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                
                                const data = await response.json();
                                if (data && data.token) {
                                    const form = document.getElementById('contact-form');
                                    const tokenInput = form.querySelector('input[name="_token"]');
                                    if (tokenInput) tokenInput.value = data.token;
                                    const meta = document.querySelector('meta[name="csrf-token"]');
                                    if (meta) meta.setAttribute('content', data.token);
                                    statusEl.textContent = 'Token diperbarui';
                                } else {
                                    statusEl.textContent = 'Gagal memperbarui token';
                                }
                            } catch (e) {
                                console.error('Gagal refresh token CSRF', e);
                                statusEl.textContent = 'Gagal refresh token - Coba refresh halaman';
                                
                                // For mobile, suggest page refresh
                                const ua = navigator.userAgent || '';
                                const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile/i.test(ua);
                                if (isMobile) {
                                    setTimeout(() => {
                                        if (confirm('Token gagal diperbarui. Refresh halaman?')) {
                                            window.location.reload();
                                        }
                                    }, 2000);
                                }
                            }
                            setTimeout(() => statusEl.textContent = '', 5000);
                        }
                        
                        document.getElementById('refresh-contact-token')?.addEventListener('click', refreshContactCSRFToken);
                        
                        // More aggressive auto-refresh for mobile
                        document.addEventListener('visibilitychange', () => {
                            if (document.visibilityState === 'visible') {
                                const ua = navigator.userAgent || '';
                                const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile/i.test(ua);
                                if (isMobile) {
                                    refreshContactCSRFToken();
                                }
                            }
                        });
                        
                        // Auto-refresh every 30 seconds for mobile
                        const ua = navigator.userAgent || '';
                        const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile/i.test(ua);
                        if (isMobile) {
                            setInterval(() => {
                                refreshContactCSRFToken();
                            }, 30000); // Refresh every 30 seconds
                        }
                        
                        const contactFormEl = document.getElementById('contact-form');
                        if (contactFormEl) {
                            contactFormEl.addEventListener('submit', async (e) => {
                                const ua = navigator.userAgent || '';
                                const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile/i.test(ua);
                                if (isMobile) {
                                    e.preventDefault();
                                    
                                    // Use mobile-specific route
                                    const mobileAction = contactFormEl.getAttribute('data-mobile-action');
                                    if (mobileAction) {
                                        contactFormEl.action = mobileAction;
                                    }
                                    
                                    // Try mobile route first
                                    try {
                                        const formData = new FormData(contactFormEl);
                                        const response = await fetch(mobileAction, {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json'
                                            }
                                        });
                                        
                                        if (response.ok) {
                                            const result = await response.json();
                                            if (result.success) {
                                                alert('Pesan berhasil dikirim!');
                                                contactFormEl.reset();
                                                return;
                                            }
                                        }
                                    } catch (error) {
                                        console.log('Mobile route failed, trying regular route');
                                    }
                                    
                                    // Fallback to regular route
                                    contactFormEl.action = '{{ route("contact.store") }}';
                                    await refreshContactCSRFToken();
                                    setTimeout(() => contactFormEl.submit(), 100);
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Sekolah</h2>
                <p class="text-lg text-gray-600">Temukan lokasi SMP Negeri 01 Namrole di peta</p>
            </div>
            
            <!-- Google Maps Link -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-8 border border-blue-200 shadow-lg">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Temukan Lokasi SMP Negeri 01 Namrole</h3>
                    <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                        Klik tombol di bawah untuk melihat lokasi sekolah di Google Maps dan mendapatkan petunjuk arah
                    </p>
                    <a href="https://maps.app.goo.gl/9m3WFjcx9Pvte2298" 
                       target="_blank" 
                       class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Buka di Google Maps
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
