export default function guest({ next, store }) {
  if (store.state.token != null) {
    next({
      name: 'dashboard',
    });
  }

  next();
}
