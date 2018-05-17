#include <stdio.h>
#include <unistd.h>

int main(){
	int pid = fork();
	if(pid == -1){
		printf("error\n");
	}else if(pid == 0){
		printf("child\n");
		getchar();
	}else{
		printf("This is parent,child id -- %d\n",pid);
		getchar();
	}
	return 0;

}
