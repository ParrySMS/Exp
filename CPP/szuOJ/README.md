- 二维矩阵
```C

//init
int **line = new int*[m]();
for(i=0; i<m; i++) {
	line[i] = new int[n];
}

//load
	int *data_p = *(line+i) + j ;
	int data = line[i][j];
	
//foreach - 1 两循环
for(i=0; i<m; i++) {
	for(j=0; j<n; j++) {
		cout<<line[i][j]<<endl;
	}
}

//foreach - 2 指针单循环
int *p = line[0][0];
for(i=0; i<m*n; i++) {
	cout<<*p<<endl;
	p++;	
}


//free
	
for(i = 0; i < n; i++) {
	delete[] line[i];
}
delete [] line;

```

- 小数位数控制输出

```C
#include <iomanip>

cout<<setiosflags(ios::fixed) <<setprecision(1)<<min<<endl;
```



- 奇奇怪怪的OJ 使用不了strupr, 用这个方法转化大小写

```C
#include <cctype>

char* upper(char * str) {
//	return strupr(str);
	char *orign=str;
	for (; *str!='\0'; str++)
		*str = toupper(*str);
	//	 *str = tolower(*str);
	return orign;

}

```

- 字符数组输出

```C
char *res = new char[35];
cout<<res<<endl; //首地址即可输出全部

```
