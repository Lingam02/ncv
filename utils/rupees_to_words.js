// function convertRupeesToWords(amount) {
//     const ones = {
//         0: 'Zero',
//         1: 'One',
//         2: 'Two',
//         3: 'Three',
//         4: 'Four',
//         5: 'Five',
//         6: 'Six',
//         7: 'Seven',
//         8: 'Eight',
//         9: 'Nine'
//     };

//     const twos = {
//         10: 'Ten',
//         11: 'Eleven',
//         12: 'Twelve',
//         13: 'Thirteen',
//         14: 'Fourteen',
//         15: 'Fifteen',
//         16: 'Sixteen',
//         17: 'Seventeen',
//         18: 'Eighteen',
//         19: 'Nineteen',
//         20: 'Twenty',
//         30: 'Thirty',
//         40: 'Forty',
//         50: 'Fifty',
//         60: 'Sixty',
//         70: 'Seventy',
//         80: 'Eighty',
//         90: 'Ninety'
//     };

//     const suffixes = {
//         '': '',
//         100: 'Hundred',
//         1000: 'Thousand',
//         100000: 'Lakh',
//         10000000: 'Crore'
//     };

//     if (isNaN(amount)) {
//         return 'Not a valid number';
//     }

//     if ((amount >= 1 && amount < 10) || (amount > -10 && amount < 0)) {
//         return ones[amount];
//     }

//     if ((amount >= 10 && amount < 100) || (amount <= -10 && amount > -100)) {
//         if (amount < 0) {
//             return 'Negative ' + convertRupeesToWords(-amount);
//         }
//         if (amount <= 20) {
//             return twos[amount];
//         }
//         const remainder = amount % 10;
//         return twos[Math.floor(amount - remainder)] + ' ' + ones[remainder];
//     }

//     for (const key of Object.keys(suffixes)) {
//         if (amount < key) {
//             continue; // Skip the current iteration if amount is less than key
//         }
//         const quotient = Math.floor(amount / key);
//         const remainder = amount % key;
//         let output = '';
//         if (key != 100 && key != 1000) {
//             output = convertRupeesToWords(quotient) + ' ' + suffixes[key] + ' ';
//         } else {
//             output = convertRupeesToWords(quotient) + ' ' + suffixes[key];
//         }
//         if (remainder > 0) {
//             output += 'and ' + convertRupeesToWords(remainder);
//         }
//         return output;
//     }
// }

// // Example usage:
// // const amount = 1234567; // Change this to the desired amount
// // const words = convertRupeesToWords(amount);
// // console.log("Rupees " + words + " Only");
//=======================================================================================

function convertRupeesToWords(amount) {
    const ones = [
        'Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'
    ];

    const twos = [
        '', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    ];

    const tens = [
        '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
    ];

    const suffixes = [
        '', 'Thousand', 'Lakh', 'Crore'
    ];

    function convertTwoDigitNumber(num) {
        if (num < 10) {
            return ones[num];
        } else if (num < 20) {
            return twos[num - 9];
        } else {
            const ten = Math.floor(num / 10);
            const one = num % 10;
            return tens[ten] + (one > 0 ? ' ' + ones[one] : '');
        }
    }

    function convertThreeDigitNumber(num) {
        const hundred = Math.floor(num / 100);
        const remaining = num % 100;
        let result = '';
        if (hundred > 0) {
            result += ones[hundred] + ' Hundred';
            if (remaining > 0) {
                result += ' and ';
            }
        }
        if (remaining > 0) {
            result += convertTwoDigitNumber(remaining);
        }
        return result;
    }

    if (isNaN(amount)) {
        return 'Not a valid number';
    }

    if (amount === 0) {
        return 'Zero Rupees';
    }

    let words = '';
    const crore = Math.floor(amount / 10000000);
    const lakh = Math.floor((amount % 10000000) / 100000);
    const thousand = Math.floor((amount % 100000) / 1000);
    const remaining = Math.floor(amount % 1000);

    if (crore > 0) {
        words += convertThreeDigitNumber(crore) + ' Crore ';
    }
    if (lakh > 0) {
        words += convertThreeDigitNumber(lakh) + ' Lakh ';
    }
    if (thousand > 0) {
        words += convertThreeDigitNumber(thousand) + ' Thousand ';
    }
    if (remaining > 0) {
        words += convertThreeDigitNumber(remaining);
    }

    const paise = Math.round((amount - Math.floor(amount)) * 100);
  
    const paiseWords = convertTwoDigitNumber(paise);
  //  console.log(paise);
    if (paiseWords && paise>0) {
        words += ' and ' + paiseWords + ' Paise';
    }

    return 'Rupees ' + words + ' Only';
}

// Example usage:
// const amount = 234.52; // Change this to the desired amount
// const words = convertRupeesToWords(amount);
// console.log(words);
//===========================================

