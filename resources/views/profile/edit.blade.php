@extends('layouts.public')

@section('title', 'Profile Settings - IronPulse Gym')

@section('content')

<div class="py-12 sm:py-16 bg-neutral-950 min-h-[80vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Header -->
        <div class="border-b border-neutral-900 pb-6 flex justify-between items-end">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-rose-500">Account Management</span>
                <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white mt-1">
                    PROFILE SETTINGS
                </h1>
                <p class="text-xs sm:text-sm text-neutral-400 mt-1">
                    Update your athlete personal details, phone number, and account security.
                </p>
            </div>
            <div>
                <a href="{{ route('member.memberships') }}" class="text-xs font-bold uppercase tracking-wider text-rose-500 hover:text-rose-400">
                    &larr; Back to Memberships
                </a>
            </div>
        </div>

        <!-- Section 1: Profile Information -->
        <div class="p-6 sm:p-10 rounded-3xl bg-neutral-900 border border-neutral-800 shadow-2xl space-y-6">
            <div class="border-b border-neutral-800/80 pb-4">
                <h3 class="text-lg font-bold uppercase text-white tracking-wide">Personal Information & Avatar</h3>
                <p class="text-xs text-neutral-400">Update your name, email address, contact phone, and avatar photo.</p>
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Current Avatar Preview & Upload -->
                <div class="flex items-center space-x-6">
                    <div class="h-20 w-20 rounded-2xl bg-neutral-950 border-2 border-neutral-800 flex items-center justify-center overflow-hidden shrink-0">
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-2xl font-black text-rose-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1">
                            Upload Avatar Photo
                        </label>
                        <input id="image" name="image" type="file" accept="image/*"
                               class="text-xs text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-600 file:text-white hover:file:bg-rose-500 cursor-pointer">
                        <p class="text-[11px] text-neutral-500 mt-1">PNG, JPG or WebP up to 2MB.</p>
                        @error('image')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Full Name <span class="text-rose-500">*</span>
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('name')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('email')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Phone Number
                    </label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="+20 10 1234 5678"
                           class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-600 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                    @error('phone')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="submit" 
                            class="px-8 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-rose-950/60 transition">
                        Save Changes
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-xs font-semibold text-emerald-400 animate-pulse">
                            &check; Profile updated successfully
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Section 2: Update Password -->
        <div class="p-6 sm:p-10 rounded-3xl bg-neutral-900 border border-neutral-800 shadow-2xl space-y-6">
            <div class="border-b border-neutral-800/80 pb-4">
                <h3 class="text-lg font-bold uppercase text-white tracking-wide">Security & Password</h3>
                <p class="text-xs text-neutral-400">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Current Password
                    </label>
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                           class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="update_password_password" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            New Password
                        </label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('password', 'updatePassword')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Confirm New Password
                        </label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('password_confirmation', 'updatePassword')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="submit" 
                            class="px-8 py-3 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs uppercase tracking-wider border border-neutral-700 transition">
                        Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-xs font-semibold text-emerald-400 animate-pulse">
                            &check; Password updated successfully
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Section 3: Delete Account -->
        <div class="p-6 sm:p-10 rounded-3xl bg-neutral-900 border border-rose-950/60 shadow-2xl space-y-6" x-data="{ confirmingDeletion: false }">
            <div class="border-b border-neutral-800/80 pb-4">
                <h3 class="text-lg font-bold uppercase text-rose-400 tracking-wide">Delete Account</h3>
                <p class="text-xs text-neutral-400">Once your account is deleted, all subscription history and profile data will be permanently removed.</p>
            </div>

            <button type="button" @click="confirmingDeletion = true"
                    class="px-6 py-3 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 border border-rose-800 text-rose-300 font-bold text-xs uppercase tracking-wider transition">
                Delete Account
            </button>

            <!-- Deletion Modal -->
            <div x-show="confirmingDeletion" style="display: none;" 
                 class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="bg-neutral-900 border border-neutral-800 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl">
                    <h4 class="text-xl font-bold uppercase text-white">Are you absolutely sure?</h4>
                    <p class="text-xs text-neutral-400">
                        Please enter your password to confirm you would like to permanently delete your IronPulse account.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                        @csrf
                        @method('delete')

                        <div>
                            <input id="password" name="password" type="password" placeholder="Confirm your password" required
                                   class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            @error('password', 'userDeletion')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-2">
                            <button type="button" @click="confirmingDeletion = false"
                                    class="px-5 py-2.5 rounded-xl bg-neutral-800 text-neutral-300 text-xs font-bold uppercase">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold uppercase">
                                Permanently Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
