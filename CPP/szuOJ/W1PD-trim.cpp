#include <stdio.h>
#include <string>
#include <iostream>
using namespace std;

// 从src删除字符ch,存到dst并返回
char *strRemov(char* dst, const char* src, char ch = ' ') {
	int i = -1, j = 0;
	while (src[++i])
		if (src[i] != ch)
			dst[j++] = src[i];
	dst[j] = '\0';
	return dst;
}

int main() {
	char src[100];
	char dst[100];
	int t;
	cin>>t;
	cin.getline(src,100);
	while(t--) {
		cin.getline(src,100);
		puts(strRemov(dst, src));
	}
	return 0;
}
