/*
Sonza, Christian Jay, H.
123, Petal Str., Agdao, Davao City
09123456789
myemail@email.com
One1!aAaAaA
*/
/*
Molero, Raffi, O.
123, Marco Polo St., Thor, Davao City
0987-654-3210
rmolero@addu.edu.ph
rRaA41234++
*/

function validate() {
    err = '';

    // custname
    if (!/^[A-Z][a-z]*, (?:[A-Z][a-z]* )*[A-Z][a-z]*, [A-Z]\.$/.test(custname.value)) {
        err += "Name must follow the format Lastname, Firstname, M.\n";
    }

    // address
    if (!/^\w+, [\w \.]+, [\w \.]+, [\w \.]+$/.test(address.value)) {
        err += "Address must follow the format Blk. Street. Barangay, City\n";
    }

    // number
    if (!/^09\d{2}-\d{3}-\d{4}$/.test(number.value)) {
        err += "Number must be a valid number like 0912-345-6789\n";
    }

    // email
    if (!/^[\w\.]+@\w+(?:\.\w+)+$/.test(email.value)) {
        err += "Email must be a valid email like name@example.com\n";
    }

    // password
    if (!/\W/.test(password.value)) {
        err += "Password must contain at least one special character\n";
    }
    if (!/\d/.test(password.value)) {
        err += "Password must contain at least one digit\n";
    }
    if (!/[a-z]/.test(password.value)) {
        err += "Password must contain at least one lowercase letter\n";
    }
    if (!/[A-Z]/.test(password.value)) {
        err += "Password must contain at least one CAPITAL LETTER\n";
    }
    if (!/.{8,}/.test(password.value)) {
        err += "Password must be at least 8 characters\n";
    }

    // confirmpassword
    if (confirmpassword.value !== password.value) {
        err += "Confirm Password must match Password\n";
    }

    success = err === '';
    if (success) {
        alert('Registered.');
    } else {
        alert('Failed to register:\n\n' + err);
    }
    return success;
}