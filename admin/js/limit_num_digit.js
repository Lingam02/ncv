function limitDecimal(input, maxDigits) {
    if (input.value.includes('.')) {
        let integerPart = input.value.split('.')[0];
        let decimalPart = input.value.split('.')[1];
        if (integerPart.length > maxDigits || decimalPart.length > 2) {
            input.value = input.value.slice(0, -1);
        }
    } else {
        if (input.value.length > maxDigits) {
            input.value = input.value.slice(0, -1);
        }
    }
}
