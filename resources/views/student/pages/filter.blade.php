<!-- Filters -->
<form method="GET"
      class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 border border-gray-200 dark:border-gray-700">

    @isset($hidden)
        @foreach( $hidden as $key=>$value)
            <input type="hidden" name="{{$key}}" value="{{$value}}">
        @endforeach
    @endisset

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($filters as $filter)
            <div>
                <label for="{{ $filter['name'] }}" class="block text-lg font-bold mb-2">
                    {{ $filter['label'] }}
                </label>
                @switch($filter['type'])
                    @case('text')
                        <input type="text" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                               value="{{ request($filter['name']) }}"
                               placeholder="{{$filter['placeholder'] ?? null}}"
                               class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"/>
                        @break

                    @case('number')
                        <input type="number" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                               value="{{ request($filter['name']) }}"
                               placeholder="{{$filter['placeholder'] ?? null}}"
                               class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"/>
                        @break

                    @case('decimal')
                        <input type="text" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                               value="{{ toCurrency(request($filter['name'])) }}"
                               placeholder="{{$filter['placeholder'] ?? null}}"
                               class="separator w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"/>
                        @break
                    @case('date')

                        @if(app()->getLocale() == 'fa')
                            <input data-jdp type="text" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                   value="{{ request($filter['name']) }}"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                    focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"/>
                        @else
                            <input type="date" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                   value="{{ request($filter['name']) }}"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"/>
                        @endif
                        @break

                    @case('select')
                        <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                class="select2 w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                       focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">-- همه --</option>
                            @foreach($filter['options'] as $val => $text)
                                <option value="{{ $val }}" {{ request($filter['name']) == $val ? 'selected' : '' }}>
                                    {!! $text !!}
                                </option>
                            @endforeach
                        </select>
                        @break
                @endswitch
            </div>
        @endforeach
    </div>
    <!-- filter button -->
    <div class="flex gap-5 flex-wrap mt-4">
        <div class="self-end">
            <button type="submit"
                    class="px-15 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                @lang('general.do_filter')
            </button>
        </div>
        <div class="self-end">
            <button class="px-15 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <a href="{{$back}}">
                    @lang('general.clear_filter')
                </a>
            </button>
        </div>
    </div>
</form>




