let path = window.location.pathname;
console.log(path);
if (path === '/') {
    path += 'index';
}
window.location.href = `/views${path}.php`;