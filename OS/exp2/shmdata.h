#ifndef _SHMDATA_H_HEADER  
#define _SHMDATA_H_HEADER  
  
#define TEXT_SZ 2048  
  
struct shared_use_st  
{  
    int written;//��Ϊһ����־����0����ʾ�ɶ���0��ʾ��д  
    char text[TEXT_SZ];//��¼д��Ͷ�ȡ���ı�  
};  
  
#endif  
