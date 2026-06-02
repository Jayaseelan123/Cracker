@extends('layouts.admin')

@section('title', 'Site Settings')
@section('header', 'Site Settings')

@push('head')
    {{-- Tagify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">

    <style>
        /* ─── Layout ─────────────────────────────────────── */
        .settings-wrap {
            padding-bottom: 100px;
        }

        /* ─── Card shell ─────────────────────────────────── */
        .s-card {
            background: #fff;
            border: 1px solid #dde1e7;
            border-radius: 6px;
            margin-bottom: 22px;
            overflow: hidden;
        }

        .s-card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 16px;
            background: #f7f8fa;
            border-bottom: 1px solid #dde1e7;
        }

        .s-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .s-card-body {
            padding: 14px 16px;
        }

        /* ─── Product Display radios ─────────────────────── */
        .pd-setting {
            margin-bottom: 18px;
        }

        .pd-setting:last-child {
            margin-bottom: 4px;
        }

        .pd-label {
            display: block;
            font-size: 13px;
            color: #333;
            margin-bottom: 7px;
        }

        .pd-opts {
            display: flex;
            gap: 28px;
        }

        .pd-opts label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            color: #111;
            cursor: pointer;
            user-select: none;
        }

        .pd-opts input[type="radio"] {
            -webkit-appearance: none;
            appearance: none;
            width: 17px;
            height: 17px;
            border: 1.5px solid #aaa;
            border-radius: 50%;
            cursor: pointer;
            flex-shrink: 0;
            transition: border-color .15s;
        }

        .pd-opts input[type="radio"]:checked {
            border: 5px solid #0d6efd;
            background: #fff;
        }

        /* ─── Terms list ─────────────────────────────────── */
        .term-row {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }

        .term-row input[type="text"] {
            flex: 1;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 7px 11px;
            font-size: 13px;
            color: #444;
            outline: none;
            transition: border-color .2s;
        }

        .term-row input[type="text"]:focus {
            border-color: #86b7fe;
        }

        .btn-del {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            width: 36px;
            min-width: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-del:hover {
            background: #bb2d3b;
        }

        .btn-plus {
            background: #2c3e50;
            color: #fff;
            border: none;
            border-radius: 4px;
            width: 28px;
            height: 28px;
            font-size: 20px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-plus:hover {
            background: #1a252f;
        }

        /* ─── Zone card fieldset ─────────────────────────── */
        .mini-field {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 2px 10px 6px;
            background: #fff;
        }

        .mini-field legend {
            font-size: 10.5px;
            color: #888;
            padding: 0 3px;
            width: auto;
            line-height: 1.2;
            margin-bottom: 0;
        }

        .mini-field input {
            border: none;
            width: 100%;
            outline: none;
            font-size: 13.5px;
            color: #222;
            padding: 0;
            background: transparent;
        }

        /* ─── Tagify overrides ───────────────────────────── */
        .tagify {
            --tags-border-color: #ced4da;
            --tag-bg: #e9ecef;
            --tag-remove-btn-color: #555;
            border-radius: 4px;
            min-height: 36px;
        }

        .tagify__dropdown {
            border: 1px solid #dde1e7 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            border-radius: 6px !important;
            background: #fff !important;
            max-height: 250px !important;
            overflow-y: auto !important;
            z-index: 9999 !important;
        }

        .tagify__dropdown__item {
            padding: 8px 12px !important;
            font-size: 13.5px !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }

        .tagify__dropdown__item--active {
            background: #0d6efd !important;
            color: #fff !important;
        }

        .tagify--focus {
            --tags-border-color: #86b7fe;
        }

        /* ─── Floating save ──────────────────────────────── */
        .float-save {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 1050;
            padding: 11px 28px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            background: #198754;
            color: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .2);
            cursor: pointer;
            transition: background .2s, transform .15s;
        }

        .float-save:hover:not(:disabled) {
            background: #146c43;
            transform: translateY(-2px);
        }

        .float-save:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        /* ─── Toast ──────────────────────────────────────── */
        .toast-msg {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 2000;
            padding: 12px 22px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .2);
            display: none;
        }

        .toast-msg.show {
            display: block;
        }

        .toast-msg.success {
            background: #198754;
        }

        .toast-msg.error {
            background: #dc3545;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    {{-- Toast --}}
    <div id="toastMsg" class="toast-msg"></div>

    <div class="settings-wrap" x-data="settingsApp()" x-init="boot()" x-cloak>

        {{-- ── Floating Save ──────────────────────────────────── --}}
        <button class="float-save" @click="saveAll" :disabled="saving">
            <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'" style="margin-right:7px;"></i>
            <span x-text="saving ? 'Saving…' : 'Save Changes'"></span>
        </button>

        {{-- ══════════════════ ROW 1 ══════════════════ --}}
        <div class="row">

            {{-- ── Product Display ─────────────────── --}}
            <div class="col-xl-4 col-lg-5">
                <div class="s-card">
                    <div class="s-card-head" style="cursor:pointer;" @click="showPd=!showPd">
                        <h5 class="s-card-title">Product Display</h5>
                        <i class="fas" :class="showPd ? 'fa-chevron-up' : 'fa-chevron-down'"
                            style="color:#888;font-size:13px;"></i>
                    </div>
                    <div class="s-card-body" x-show="showPd">

                        <div class="pd-setting">
                            <span class="pd-label">Pricelist Display In Home Page</span>
                            <div class="pd-opts">
                                <label><input type="radio" value="1" x-model="s.show_pricelist_home"> Yes</label>
                                <label><input type="radio" value="0" x-model="s.show_pricelist_home"> No</label>
                            </div>
                        </div>

                        <div class="pd-setting">
                            <span class="pd-label">Download Pricelist PDF In Frontend</span>
                            <div class="pd-opts">
                                <label><input type="radio" value="1" x-model="s.show_pricelist_download"> Yes</label>
                                <label><input type="radio" value="0" x-model="s.show_pricelist_download"> No</label>
                            </div>
                        </div>

                        <div class="pd-setting">
                            <span class="pd-label">Category Filter</span>
                            <div class="pd-opts">
                                <label><input type="radio" value="1" x-model="s.enable_category_filter"> Yes</label>
                                <label><input type="radio" value="0" x-model="s.enable_category_filter"> No</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Terms & Conditions ───────────────── --}}
            <div class="col-xl-4 col-lg-4">
                <div class="s-card">
                    <div class="s-card-head">
                        <h5 class="s-card-title">Terms & Conditions</h5>
                        <button class="btn-plus" @click="terms.push('')" title="Add term">+</button>
                    </div>
                    <div class="s-card-body">
                        <template x-for="(t, i) in terms" :key="i">
                            <div class="term-row">
                                <input type="text" x-model="terms[i]" placeholder="Enter term text…">
                                <button class="btn-del" @click="terms.splice(i,1)" title="Remove">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </template>
                        <p x-show="terms.length === 0" class="text-muted small mb-0">
                            No terms yet — click <strong>+</strong> to add one.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── State Selector ───────────────────── --}}
            <div class="col-xl-4 col-lg-3">
                <div class="s-card">
                    <div class="s-card-head">
                        <h5 class="s-card-title">State</h5>
                    </div>
                    <div class="s-card-body">
                        <input type="text" id="stateTagifyInput" class="w-100" placeholder="Type a state and press Enter…">
                    </div>
                </div>
            </div>

        </div>{{-- /ROW 1 --}}

        {{-- ══════════════════ ROW 2 – Dynamic Zone Cards ══════════════════ --}}
        <div class="row">
            <template x-for="(zone, zi) in zones" :key="zone.state_name">
                <div class="col-xl-6 col-lg-6">
                    <div class="s-card">
                        <div class="s-card-head">
                            <h5 class="s-card-title" x-text="zone.state_name"></h5>
                            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                                <input class="form-check-input m-0" type="checkbox" :id="'ac_'+zi"
                                    x-model="zone.all_cities">
                                <label class="form-check-label small fw-bold" :for="'ac_'+zi">All Districts</label>
                            </div>
                        </div>
                        <div class="s-card-body">

                            <div class="row mb-3">
                                <div class="col-6">
                                    <fieldset class="mini-field">
                                        <legend>Min.Order</legend>
                                        <input type="number" min="0" step="1" x-model.number="zone.min_order_amount">
                                    </fieldset>
                                </div>
                                <div class="col-6">
                                    <fieldset class="mini-field">
                                        <legend>Packing Charges</legend>
                                        <input type="number" min="0" step="1" x-model.number="zone.packing_charges">
                                    </fieldset>
                                </div>
                            </div>

                            <fieldset class="mini-field" style="padding-bottom:8px;" x-show="!zone.all_cities">
                                <legend>Select District / City</legend>
                                {{-- city tagify attached via JS --}}
                                <input type="text" :id="'city_'+zi" :data-zone-index="zi" class="city-tagify-input"
                                    placeholder="Add districts / cities…">
                            </fieldset>



                        </div>
                    </div>
                </div>
            </template>
        </div>{{-- /ROW 2 --}}

    </div>{{-- /settings-wrap --}}
@endsection

@push('scripts')
    {{-- Tagify JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    {{-- Alpine JS (defer so DOM is ready) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    @php
        $jsZones = $deliveryZones->map(function($z) {
            return [
                'state_name' => $z->state_name,
                'min_order_amount' => (float) $z->min_order_amount,
                'packing_charges' => (float) $z->packing_charges,
                'all_cities' => (bool) $z->all_cities,
                'cities' => $z->cities ?? [],
            ];
        })->toArray();
    @endphp

    <script>
        /* -------------------------------
           Blade → JS  (server-side data injection)
        ───────────────────────────────────────────────────── */
        const _INIT = {
            settings: @json($settings),
            terms: @json($termsItems->pluck('title_en')->values()),
            zones: @json($jsZones),
        };

        /* ─────────────────────────────────────────────────────
           Alpine component
        ───────────────────────────────────────────────────── */
        function settingsApp() {
            return {
                showPd: true,
                saving: false,
                stateTagify: null,
                cityTagifies: {},   // keyed by zone index

                /* ── reactive state ── */
                s: {
                    show_pricelist_home: String(_INIT.settings.show_pricelist_home ?? '1'),
                    show_pricelist_download: String(_INIT.settings.show_pricelist_download ?? '1'),
                    show_product_code: String(_INIT.settings.show_product_code ?? '0'),
                    show_discount_row: String(_INIT.settings.show_discount_row ?? '1'),
                    enable_category_filter: String(_INIT.settings.enable_category_filter ?? '1'),
                    enable_search_filter: String(_INIT.settings.enable_search_filter ?? '1'),
                    pdf_font_size: String(_INIT.settings.pdf_font_size ?? '9'),
                },
                terms: [..._INIT.terms],
                zones: JSON.parse(JSON.stringify(_INIT.zones)),

                /* ── boot ── */
                boot() {
                    fetch('/districts.json')
                        .then(res => res.json())
                        .then(data => {
                            this.districtsMap = data;
                            this.$nextTick(() => {
                                this.initStateTagify();
                                this.$nextTick(() => this.initAllCityTagifies());
                            });
                        })
                        .catch(err => {
                            console.error('Failed to load districts:', err);
                            this.districtsMap = {};
                            this.$nextTick(() => {
                                this.initStateTagify();
                                this.$nextTick(() => this.initAllCityTagifies());
                            });
                        });
                },

                /* ── State Tagify ── */
                initStateTagify() {
                    const el = document.getElementById('stateTagifyInput');
                    if (!el) return;

                    const indianStates = [
                        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", 
                        "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", 
                        "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", 
                        "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", 
                        "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", 
                        "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands", 
                        "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", 
                        "Jammu and Kashmir", "Ladakh", "Lakshadweep", "Puducherry"
                    ];

                    this.stateTagify = new Tagify(el, {
                        whitelist: indianStates,
                        enforceWhitelist: false,
                        dropdown: { 
                            enabled: 0,
                            maxItems: 40,
                            closeOnSelect: true,
                            highlightFirst: true
                        },
                    });

                    // pre-fill from current zones
                    if (this.zones.length) {
                        this.stateTagify.addTags(this.zones.map(z => z.state_name));
                    }

                    // add zone when tag added
                    this.stateTagify.on('add', e => {
                        const name = e.detail.data.value.trim();
                        if (name && !this.zones.find(z => z.state_name === name)) {
                            this.zones.push({
                                state_name: name, min_order_amount: 0,
                                packing_charges: 0, all_cities: true, cities: []
                            });
                            // init city tagify for new zone after DOM update
                            this.$nextTick(() => {
                                const idx = this.zones.length - 1;
                                this.initCityTagify(idx);
                            });
                        }
                    });

                    // remove zone when tag removed
                    this.stateTagify.on('remove', e => {
                        const name = e.detail.data.value;
                        const idx = this.zones.findIndex(z => z.state_name === name);
                        if (idx !== -1) {
                            // destroy city tagify first
                            if (this.cityTagifies[idx]) {
                                this.cityTagifies[idx].destroy();
                                delete this.cityTagifies[idx];
                            }
                            this.zones.splice(idx, 1);
                        }
                    });
                },

                /* ── City Tagify (single zone) ── */
                initCityTagify(zoneIndex) {
                    const el = document.getElementById('city_' + zoneIndex);
                    if (!el || this.cityTagifies[zoneIndex]) return;

                    const zone = this.zones[zoneIndex];
                    let whitelist = [];
                    if (this.districtsMap && this.districtsMap[zone.state_name]) {
                        whitelist = this.districtsMap[zone.state_name];
                    }

                    const t = new Tagify(el, {
                        whitelist: whitelist,
                        enforceWhitelist: false,
                        dropdown: { 
                            enabled: 0,
                            maxItems: 100,
                            closeOnSelect: false,
                            highlightFirst: true
                        },
                    });

                    // pre-fill existing cities
                    if (zone.cities && zone.cities.length) {
                        t.addTags(zone.cities);
                    }

                    t.on('change', () => {
                        try {
                            this.zones[zoneIndex].cities =
                                t.value.map(v => v.value);
                        } catch (_) {
                            this.zones[zoneIndex].cities = [];
                        }
                    });

                    this.cityTagifies[zoneIndex] = t;
                },

                /* ── Init all city tagifies at once ── */
                initAllCityTagifies() {
                    this.zones.forEach((_, i) => this.initCityTagify(i));
                },

                /* ── Save All ── */
                saveAll() {
                    this.saving = true;
                    fetch('{{ route("admin.settings.combined") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            settings: this.s,
                            terms: this.terms.filter(t => t.trim() !== ''),
                            zones: this.zones,
                        }),
                    })
                        .then(r => r.json())
                        .then(res => {
                            this.saving = false;
                            this.showToast(res.success ? 'Settings saved successfully!' : 'Error: ' + (res.message || 'Unknown error'), res.success ? 'success' : 'error');
                        })
                        .catch(err => {
                            this.saving = false;
                            console.error(err);
                            this.showToast('Network error – check console.', 'error');
                        });
                },

                /* ── Toast helper ── */
                showToast(msg, type = 'success') {
                    const el = document.getElementById('toastMsg');
                    el.textContent = msg;
                    el.className = 'toast-msg show ' + type;
                    setTimeout(() => el.className = 'toast-msg', 3000);
                },
            };
        }
    </script>
@endpush