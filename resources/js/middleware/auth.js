export default function auth({ next, store }) {
  if (store.state.token == null) {
    next({
      name: 'login',
    });
  }

  next();
}
