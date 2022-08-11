<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
        <input type="checkbox">
    </div>
</x-forms::field-wrapper>
