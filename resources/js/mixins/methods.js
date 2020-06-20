export default {
    methods: {
        route() {
            let routes = window.site.routes;
            let args = Array.from(arguments);
            let name = args.shift();

            if (routes[name] === undefined) {
                console.error('Route not found ', name);
            } else {
                return `${window.site.baseUrl}/${routes[name].split('/').map(s => s[0] === '{' ? args.shift() : s).join('/')}`;
            }
        }
    }
}