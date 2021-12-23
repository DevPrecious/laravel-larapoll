<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Bank') }}
        </h2>
    </x-slot>


    <div class="py-6 px-6">
        <div class="flex justify-center md:p-4 p-6 md:max-w-md max-w-lg mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <div class="py-4 px-4 flex flex-col">
                <span class="md:text-2xl text-xl md:flex md:justify-center font-bold">Add bank</span>
                <!-- <span class="pt-2 font-light text-lg">PollPay
            </span> -->
                @if (session()->has('success'))
                <div class="bg-green-400 rounded-lg p-4 text-white">
                    {{ session('success') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="bg-red-400 rounded-lg p-4 text-white">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('addbank') }}" method="POST" class="">
                    @csrf
                    <div class="pt-6">
                        <input type="text" name="acc_number" value="{{ $bank->acc_number ? $bank->acc_number : '' }}" class="@error('acc_number') ring-red-500 text-white @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Account number" />
                        @error('acc_number') {{ $message }} @enderror
                    </div>
                    <div class="pt-6">
                        <input type="text" readonly name="acc_name" value="{{ $bank->acc_name ? $bank->acc_name : '' }}" class="@error('acc_name') ring-red-500 text-white @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Account number" />
                        @error('acc_number') {{ $message }} @enderror
                    </div>
                    Bank: {{ $bank->bank_code ? $bank->bank_code : '' }}
                    
                    <div class="pt-6">
                       <select name="bank_code" id="">
                           <option value="044">Access Bank Nigeria Plc</option>
                           <option value="063">Diamond Bank Plc</option>
                           <option value="050">Ecobank Nigeria</option>
                           <option value="084">Enterprise Bank Plc</option>
                           <option value="070">Fidelity Bank Plc</option>
                           <option value="011">First Bank of Nigeria Plc</option>
                           <option value="214">First City Monument Bank</option>
                           <option value="058">Guaranty Trust Bank Plc</option>
                           <option value="030">Heritaage Banking Company Ltd</option>
                           <option value="301">Jaiz Bank</option>
                           <option value="082">Keystone Bank Ltd</option>
                           <option value="014">Mainstreet Bank Plc</option>
                           <option value="076">Skye Bank Plc</option>
                           <option value="039">Stanbic IBTC Plc</option>
                           <option value="232">Sterling Bank Plc</option>
                           <option value="032">Union Bank Nigeria Plc</option>
                           <option value="033">United Bank for Africa Plc</option>
                           <option value="215">Unity Bank Plc</option>
                           <option value="035">WEMA Bank Plc</option>
                           <option value="057">Zenith Bank International</option>
                       </select>
                    </div>
                    <!-- <div class="pt-6">
                    <input type="password" name="password" class="rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Password" />
                </div> -->
                    <div class="pt-6">
                        <div class="flex justify-center md:p-1 p-2 max-w-lg mx-auto bg-blue-500 rounded-xl shadow-md">
                            <button type="submit" class="text-white flex justify-evenly">
                                Add bank
                            </button>
                        </div>
                    </div>
                    <!-- <div class="pt-6">
                    <input type="checkbox" name="" id="">
                    <span class="font-thin text-md">Remember me</span>
                </div> -->
                </form>
            </div>
        </div>
    </div>

</x-app-layout>