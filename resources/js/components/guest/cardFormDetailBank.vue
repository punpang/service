<template>
  <div>
    <v-simple-table v-for="detailBank in detailBanks" :key="detailBank.id">
      <tbody>
        <tr>
          <td colspan="2">
            <strong>{{ detailBank.bank_name }}</strong>
          </td>
        </tr>
        <tr>
          <td>ชื่อบัญชี</td>
          <td class="text-right">{{ detailBank.bank_account }}</td>
        </tr>
        <tr>
          <td>เลขบัญชี</td>
          <td class="text-right">
            <v-btn
              x-small
              class="info"
              elevation="0"
              v-clipboard:copy="detailBank.bank_number"
              v-clipboard:success="onCopy"
              >คัดลอก</v-btn
            >
            {{ detailBank.bank_number }}
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      detailBanks: [
        {
          id: 1,
          bank_name: "ธนาคารไทยพาณิชย์",
          bank_account: "ฐิติภัทร ศรีสุข",
          bank_number: "4191081549",
        },
        {
          id: 2,
          bank_name: "พร้อมเพย์",
          bank_account: "ฐิติภัทร ศรีสุข",
          bank_number: "0918853402",
        },
      ],
    };
  },
  methods: {
    onCopy() {
      this.$swal({
        title: "คัดลอกแล้ว",
        icon: "success",
        allowOutsideClick: false,
        timerProgressBar: true,
        timer: 3000,
        showConfirmButton: false,
      });
    },
  },
};
</script>