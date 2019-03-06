#include <stdio.h>
#include <sys/time.h>
#define MOD 1000000

int f5(int);

int main() {
	struct timeval tv1;
	struct timeval tv2;
	int t=10000;
	gettimeofday(&tv1,NULL);
	while(t--) {
		f5(10000);
	}
	gettimeofday(&tv2,NULL);
	printf("1 start, now, sec=%ld m_sec=%ld \n", tv1.tv_sec, tv1.tv_usec);
	printf("2 start, now, sec=%ld m_sec=%ld \n", tv2.tv_sec, tv2.tv_usec);

	return 0;
}

int f5(int n) {
	int fa_res,fnum,sum;
	if (n > 24) n = 24;//发现的规律
	fa_res = 1;
	for (fnum = 1, sum = 0; fnum <= n; fnum++) {
		if (n > 20 && sum > 999999) { //如果大数临界 并且sum是超过6位了 才有必要进行取余
			fa_res = (fnum * fa_res)%MOD;
			sum = (sum + fa_res)%MOD;
		} else {
			fa_res = fnum * fa_res; // 利用上一次的保存结果
			sum = sum + fa_res; // 求和 重复到n
		}
	}
	return sum > 999999 ? sum%MOD : sum;
}
