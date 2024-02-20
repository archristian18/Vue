import api from "../utils/api";

const createRegister = async (data) => {
  const req = api.post("/register", data).then(({ data }) => data.data);
  return await req;
};

export { createRegister };
