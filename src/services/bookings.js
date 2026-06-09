import api, { getCsrf } from "./api";

export async function createBooking(bookingData) {
  await getCsrf();
  const { data } = await api.post("/api/bookings", bookingData);
  return data.data.booking;
}

export async function getMyBookings() {
  const { data } = await api.get("/api/bookings");
  return data.data.bookings;
}

export async function cancelBooking(id) {
  await getCsrf();
  const { data } = await api.patch(`/api/bookings/${id}/cancel`);
  return data.data.booking;
}
