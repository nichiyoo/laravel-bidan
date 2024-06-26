<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Artikel') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Artikel pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.articles.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="search" :value="__('fields.search.label')" />
                <x-input id="search" type="text" name="search"
                    placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>

            <div class="w-full min-w-40">
                <x-label for="status" :value="__('articles.status.label')" />
                <x-select id="status" name="status" required x-on:input="$form.submit()">
                    <option value="" @if ($status == null) selected @endif>
                        {{ __('articles.status.placeholder') }}
                    </option>

                    @foreach ($statuses as $item)
                        <option value="{{ $item }}" @if ($item == $status) selected @endif>
                            {{ \Illuminate\Support\Str::title($item) }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </form>

        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admins.articles.create') }}">
                <x-button variant="accent">
                    <i data-lucide="plus"></i>
                    {{ __('Artikel') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Judul') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Dilihat') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($articles as $article)
                <tr>
                    <td>
                        {{ \Illuminate\Support\Str::words($article->title, 7) }}
                    </td>
                    <td> <x-badge value="{{ $article->status }}" /> </td>
                    <td> <x-date value="{{ $article->created_at }}" /> </td>
                    <td> <x-badge value="{{ $article->views }}" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.articles.edit', $article) }}"
                            delete="{{ route('admins.articles.destroy', $article) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $articles->links() }}
</x-app-layout>
