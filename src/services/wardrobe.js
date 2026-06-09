import api, { getCsrf } from "./api";

export async function getItems(category = null) {
  const params = category ? { category } : {};
  const { data } = await api.get("/api/wardrobe", { params });
  return data.data.items;
}

export async function addItem(formData) {
  await getCsrf();
  const { data } = await api.post("/api/wardrobe", formData, {
    headers: { "Content-Type": "multipart/form-data" },
    transformRequest: [(payload) => payload],
  });
  return data.data.item;
}

export async function deleteItem(id) {
  await api.delete(`/api/wardrobe/${id}`);
}
