<table>
    @foreach(\App\Models\AppLanguage::langsSelect() as $lang=>$langName)
        <tr wire:key="{{ $loop->index }}">
            <td class="font-normal text-xs" style="text-align:{{ localeDirection()  }}"><b>{{ $langName.":" }}</b></td>
            <td class="text-xs" style="text-align:{{ langDirection($lang) }}">{{ $model->getTranslation($attribute,$lang,false) }}</td>
        </tr>
    @endforeach
</table>
